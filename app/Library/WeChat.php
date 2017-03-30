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
use Illuminate\Support\Facades\Input;
use phpDocumentor\Reflection\Location;

class WeChat
{
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
       $now = time();//获取当前时间
       if (empty($access_token)||$now-$get_token_time>7000){
          $this->get_token();
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
           "name":"我的订单",
           "url":"http://v.qq.com/"  
       }
       ]
 }
php;
       $result = $this->http_curl($url,$data);
   }
//获取用户公开信息
    public function unionId(){
        $open_id = session('open_id');//用户openID
        $access_token = session('access_token');//access_token
        $get_token_time =session('get_token_time');//token 创建时间
        $now = time();//获取当前时间
        if (empty($access_token)||$now-$get_token_time>7000){
            $this->get_token();
        }
      /*  $this->get_token();
        $access_token = session('access_token');//access_token*/
        //var_dump($access_token);
        //dd($open_id);
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
        $userInfo = $this->http_curl($url);
        $this->logger($userInfo);
        $userInfo = json_decode($userInfo,true); //true 则转换为数组 默认转换为对象
        //忽略这些字段
        unset($userInfo['subscribe']);
        unset($userInfo['language']);
        unset($userInfo['groupid']);
        unset($userInfo['tagid_list']);
        Customer::create($userInfo); //如果openID 没有则插入到数据库
    }
    //网页授权
    public function oauth(){
        $appid ="wx2fb8f9fd418d80c5"; //测试号的appid
        $appsecret = "416b11926695931ee5b2b23e2766838b"; //测试号的appsecret
        $redirect_uri = "http://www.lylyg2017.cn/graduate/wechat/profile"; //返回地址
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
        $code = Input::get('code'); //获取code
        if (empty($code)){
            header('location:'.$url); //跳转页面获取code
        }
       $code = Input::get('code');
       $state = Input::get('state');
//如果没有获取到code
        if (empty($code)){
            $this->logger('授权失败');
        }else{
            $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$code.'&grant_type=authorization_code';
            $token = $this->http_curl($token_url);
            $token = json_decode($token);
            if (isset($token->errcode)) {
                $errorStr =  '错误：'.$token->errcode."\n". '错误信息：'.$token->errmsg;
                $this->logger($errorStr); //把错误 信息写入日志
                exit;
            }

           /* $access_token_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$appid.'&grant_type=refresh_token&refresh_token='.$token->refresh_token;
//转成对象
            $access_token = json_decode(file_get_contents($access_token_url));
            if (isset($access_token->errcode)) {
                $errorStr= '错误：'.$access_token->errcode."\n" .'错误信息：'.$access_token->errmsg;
                $this->logger($errorStr);
                exit;
            }
            $user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token->access_token.'&openid='.$access_token->openid.'&lang=zh_CN';
//转成对象
            $user_info = json_decode(file_get_contents($user_info_url));
            if (isset($user_info->errcode)) {
                $errorStr = '错误：'.$user_info->errcode."\n". '错误信息：'.$user_info->errmsg;
                exit;
            }

            $rs =  json_decode(json_encode($user_info),true);//返回的json数组转换成array数组

//打印用户信息
            /*  echo '<pre>';
              print_r($rs);
              echo $rs['openid'];
              echo '</pre>';*/
           // session(['open_id'=>$rs['openid']]); //把openID存入session*/
        }
    }
//获取openid
    public function get_openId(){
        $open_id = session('FromUserName');//用户openID
        $this->logger("openId:".$open_id);
        return $open_id;
    }
    /*自动回复文本消息*/
    public function receive(){
        //$obj = $GLOBALS['HTTP_RAW_POST_DATA']; //使用全局函数接收发送的内容
        $obj = file_get_contents("php://input");
        $postSql = simplexml_load_string($obj,'SimpleXMLElement',LIBXML_NOCDATA);//把xml文本转换成php对象并且去除文本中的CDATA
        $this->logger("接收：\n".$obj);
        if(!empty($postSql)){
            //session(['open_id'=>$postSql->FromUserName]);//把用户的openID写入session
            if ($postSql->Event == 'subscribe'){
                $result = $this->receiveEvent($postSql);//关注自动回复消息
                $this->menu();   //初始化菜单
               // $this->unionId();//获取用户公开信息
            }elseif(trim($postSql->Event)=="CLICK"){
                switch (trim($postSql->MsgType)){ //判断消息类型
                    case "text":
                        $result= $this->receiveText($postSql); //如果是文本消息则
                        break;
                    case "event":
                        $result = $this->repository($postSql);//获取问题类型
                }
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
        $appid ="wx2fb8f9fd418d80c5"; //测试号的appid
        $secret = "416b11926695931ee5b2b23e2766838b"; //测试号的appsecret
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
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