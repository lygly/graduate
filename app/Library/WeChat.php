<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/24
 * Time: 9:19
 */

namespace APP\Library;


use App\Http\Model\Customer;
use App\Http\Model\Dictionary;
use App\Http\Model\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\Location;

class WeChat
{
 private  $appid ="wx2fb8f9fd418d80c5"; //测试号的appid
 private  $appsecret = "416b11926695931ee5b2b23e2766838b"; //测试号的appsecret
    /*微信接口配置函数*/
    public function checkSignature()
    {
        $signature = Input::get("signature");//加密签名
        $timestamp = Input::get("timestamp");//时间戳
        $nonce = Input::get("nonce");	//随机数

        $token = 'lylyg';//token
        $tmpArr = array($token, $timestamp, $nonce);//组成新数组
        sort($tmpArr, SORT_STRING);//重新排序
        $tmpStr = implode( $tmpArr );//转换成字符串
        $tmpStr = sha1( $tmpStr );//再将字符串进行加密
        /*
         * 1.组成数组
         * 2.组成新的加密函数
         * 3.跟传过来的加密签名进行匹配
         * */

        if( $tmpStr == $signature ){
            echo Input::get('echostr');
        }else{
            return false;
        };
    }
   /*
    * 设置自定义菜单
    * */
   public function menu(){
       $access_token = session('access_token');//access_token
       $get_token_time =session('get_token_time');//token 创建时间
       $this->logger("token_time:".$get_token_time);
       $now = time();//获取当前时间
       if (empty($access_token)||$now-$get_token_time>7000){
          $this->get_token();
          $access_token = session('access_token');//access_token
       }
       $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";//自定义菜单接口
       $data = <<<php
{
     "button":[
     {	
          "type":"view",
          "name":"微信商城",
          "url":"http://www.lylyg2017.cn/graduate/wechat"
      },
      {
           "type":"click",
           "name":"在线咨询",
           "key":"V1001_ONLINE_CONSULTATION"
         
       },
        {
           "type":"view",
           "name":"意见反馈",
           "url":"http://www.lylyg2017.cn/graduate/wechat/suggestion"  
       }
       ]
 }
php;
        $result = $this->http_curl($url,$data);
        $this->logger("自定义菜单返回值：".$result);
   }
    /**
     * 获取微信授权链接
     *
     * @param string $redirect_uri 跳转地址
     * @param mixed $state 参数
     */
    public function get_authorize_url($redirect_uri = '', $state = '')
    {
        $redirect_uri = urlencode($redirect_uri);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
    }

    /**
     * 获取授权token
     *
     * @param string $code 通过get_authorize_url获取到的code
     */
    public function get_access_token($code)
    {
        $this->logger("code:".$code);
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->appid}&secret={$this->appsecret}&code={$code}&grant_type=authorization_code";
        $token = $this->http_curl($token_url);
        $this->logger("token:".$token);
        $token=json_decode($token);
        if (!isset($token->errcode)){
            $access_token = $token->access_token;
            $open_id = $token->openid;
            $this->unionId($access_token,$open_id);//获取用户公开信息
            return $token->openid;
        }
        return false;
    }
    //获取用户公开信息
    public function unionId($access_token,$open_id){
        //$url="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
        $userInfo = $this->http_curl($url);
        $this->logger("userInfo:".$userInfo);
        $userInfo = json_decode($userInfo,true); //true 则转换为数组 默认转换为对象
      //  $open_id = $userInfo['openid'];
        $nickName = $userInfo['nickname'];
        $sex = $userInfo['sex'];
        $city = $userInfo['city'];
        $province = $userInfo['province'];
        $country = $userInfo['country'];
        $headImgUrl = $userInfo['headimgurl'];
        $subscribe_time = time();
        $language = $userInfo['language'];
        //Customer::create($userInfo);
        /*
         * userInfo:{"openid":"okyhUwNdRkU577OWH3XHqbddxBao","nickname":"My Sunshine","sex":2,"language":"zh_CN","city":"沙坪坝","province":"重庆","country":"中国","headimgurl":"http:\/\/wx.qlogo.cn\/mmopen\/83KGOWp0YHpx6QI9FgQiaMtDEETbDfTK2bp9E1uRHlJsnnAbicDfMJAWBFkd44gDWK1aHvrUrys7dOL9ibPSAar5uL8bqGGggeZ\/0","privilege":[]}
         * */
        //如果openID 没有则插入到数据库有就实现更新
        $sqlStr="insert into u_customer(openId,nickName,sex,city,province,country,headimgurl,subscribe_time)VALUES('$open_id','$nickName',$sex,'$city','$province','$country','$headImgUrl',$subscribe_time)on duplicate key update subscribe_time=$subscribe_time";
        $re = DB::insert($sqlStr);
        $this->logger("数据插入/更新返回值：".$re);

    }
    /*自动回复文本消息*/
    public function receive(){
        //$obj = $GLOBALS['HTTP_RAW_POST_DATA']; //使用全局函数接收发送的内容
        $obj = file_get_contents("php://input");
        $postSql = simplexml_load_string($obj,'SimpleXMLElement',LIBXML_NOCDATA);//把xml文本转换成php对象并且去除文本中的CDATA
        $this->logger("接收：\n".$obj);
        if(!empty($postSql)){
            if ($postSql->Event == 'subscribe')
            {
                $result = $this->receiveEvent($postSql);//关注自动回复消息
                $this->menu();   //初始化菜单
               // $this->unionId();//获取用户公开信息
            }elseif(trim($postSql->Event)=="CLICK"&&trim($postSql->MsgType)=="event")
            {
                $result = $this->repository($postSql);//获取问题类型
            }elseif (trim($postSql->MsgType)=="text")
            {
                $result= $this->receiveText($postSql); //如果是文本消息则
            }
            //为了防止5s钟没反应微信服务器帮我们处理
            if (!empty($result)){
                echo $result;
            }else{
                $xml = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";
                echo $result = sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),$postSql->MsgType,"没有这条文本消息");
            }
        }

    }
    /*
    * 在线咨询问题类型
    * */
    private function repository($postSql){
        $xml = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";
        $content = "您好！请回复以下数字获得服务：\n\n";
        $data = Dictionary::where('pId',3)->orderBy('sort','asc')->get();
         foreach ($data as $k=>$r)
             $content .= ($k+1).' '.$r->names."\n";
        $result = sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),"text",$content);
        $this->logger("回复问题类别：\n".$result);
        return $result;
    }
    /*
        * 如果传送过来的内容里面含有"1"这个词语，则回复“设备问题”
        * */
    private function receiveText($postSql){
        $content = trim($postSql->Content);//提取传送过来的内容
        if (strlen($content) == 1){//如果是问题类型
            $perfixId = $content; //微信返回的类型
            switch ($content){
                case 1:
                    $result=$this->receiveQuestion($postSql,18,$perfixId);
                    break;
                case 2:
                    $result=$this->receiveQuestion($postSql,19,$perfixId);
                    break;
                case 3:
                    $result=$this->receiveQuestion($postSql,20,$perfixId);
                    break;
            }
        }else{
            $questionId = $content;
            $result = $this->receiveAnswer($postSql,$questionId);
        }
        $this->logger("发送问答消息：\n".$result);
        return $result;
    }
    /*回复问题
     * */
    private function receiveQuestion($postSql,$typeId,$perfixId){
        $xml = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";
        $content = "";
        $data = Repository::where('typeId',$typeId)->orderBy('createDate','asc')->get();
        if (count($data)!=0){
            foreach ($data as $k=>$v)
                $content.=$perfixId.$v->id.' '.$v->question."\n";
        }else{
            $content="此类问题暂无数据。";
        }
        $result = sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),$postSql->MsgType,$content);
        return $result;
    }
    /*
     * 回复答案
     * */
    private function receiveAnswer($postSql,$questionId){
        $xml = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";
        $content = "";
        $questionId = substr($questionId,1);
        $data = Repository::where('id',$questionId)->get();
        if (count($data)!=0){
            foreach ($data as $k=>$v)
                $content.=' '.$v->answer."\n";
        }else{
            $content="此问题暂无答案。";
        }
        $result = sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),$postSql->MsgType,$content);
        return $result;
    }
    /*
* 关注自动回复
* */
    private function receiveEvent($postSql){
        $xml = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>";
        $result = sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),"text","终于等到你~~~");
        $this->logger("关注自动回复：\n".$result);
        return $result;
    }
    /*抓取网页内容函数*/
    private function http_curl($url,$data=null){
        //1.初始化创建一个新的cURL资源
        $ch = curl_init();
        //2.设置url和相应的选项
        curl_setopt($ch,CURLOPT_URL,$url);
        //curl_setopt($ch,CURLOPT_HEADER,0);
        /*
         * 如果$data不为空，就直接上传数据
         * */
        if (!empty($data)){
            curl_setopt($ch,CURLOPT_POST,1);//做一个http请求
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);//传递一个作为HTTP “POST”操作的所有数据的字符串
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//禁止curl资源直接输出

        //3.抓取URL并把它传递给浏览器
        $opt = curl_exec($ch);
        //4.关闭cURL资源，并且释放系统资源
        curl_close($ch);
        return $opt;  //微信服务器返回的json数据
    }
    /*
  * 获取access_token 的函数
  * */
    private function get_token(){
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
        $json = $this->http_curl($url);
        $result = json_decode($json); //把json数组转换成php对象
        $result->get_token_time = time();
        session(['access_token'=>$result->access_token]); //写入session
        session(['get_token_time'=>$result->get_token_time]);
        $this->logger("access_token:\n".$result->access_token);
        return $result;
    }
    /*写入日志*/
    private function logger($content){
        $logSize=100000; //指定日志文件大小
        $log = storage_path('logs/wechat.log');//指定日志文件名
        if(file_exists($log)&&filesize($log) > $logSize){
            unlink($log);//删除日志文件
        }
        file_put_contents($log,date('Y-m-d H:i:s')." ".$content."\n",FILE_APPEND);//向文件写入内容并且每次在尾部追加
    }
}