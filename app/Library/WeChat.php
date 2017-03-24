<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/24
 * Time: 9:19
 */

namespace APP\Library;


use Illuminate\Support\Facades\Input;

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
       /*$access_token = $this->get_token()->access_token;
       session(['access_token'=>$this->get_token()->access_token]); //写入session
       session(['get_token_time'=>$this->get_token()->get_token_time]);*/
       $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}";//自定义菜单接口
       $data = <<<php
{
     "button":[
     {	
          "type":"view",
          "name":"微信商城",
          "url":"http://v.qq.com/"
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
       var_dump($result);
   }

    /*自动回复文本消息*/
    public function receive(){
        //$obj = $GLOBALS['HTTP_RAW_POST_DATA']; //使用全局函数接收发送的内容
        $obj = file_get_contents("php://input");
        $postSql = simplexml_load_string($obj,'SimpleXMLElement',LIBXML_NOCDATA);//把xml文本转换成php对象并且去除文本中的CDATA
        $this->logger("接收：\n".$obj);
        if(!empty($postSql)){
            switch (trim($postSql->MsgType)){ //判断消息类型
                case "text":
                    $result= $this->receiveText($postSql); //如果是文本消息则
                    break;
                case "event":
                    $result = $this->receiveEvent($postSql);//关注自动回复消息
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
        return $result;
        // return $result->access_token; //返回access_token
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