<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

define('TOKEN','lylyg');
class WeChat extends Model
{
    //微信类
    public function checkSignature()
    {
        $signature = Input::get("signature");//加密签名
        $timestamp = Input::get("timestamp");//时间戳
        $nonce = Input::get("nonce");	//随机数

        $token = TOKEN;//token
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
        }
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
        $result = sprintf($xml,$postSql->FromUserName,$postSql->ToUserName,time(),"text","欢迎关注维修微信");
        $this->logger("关注自动回复：\n".$result);
        return $result;
    }
    /* 日志*/
    private function logger($content){
        $logSize=100000; //指定日志文件大小
        $log = storage_path('logs/wechat.log');//指定日志文件名
        if(file_exists($log)&&filesize($log) > $logSize){
            unlink($log);//删除日志文件
        }
        file_put_contents($log,date('H:i:s')." ".$content."\n",FILE_APPEND);//向文件写入内容并且每次在尾部追加
    }
}
