<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\WeChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class WeChatController extends Controller
{
    //
  public function serve(){
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
      }
  }
}
