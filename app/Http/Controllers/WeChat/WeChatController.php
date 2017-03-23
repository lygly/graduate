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
      $weChat = (new WeChat); //实例化WeChat类

      $weChat ->checkSignature();//匹配公众号的接口配置信息
     /* if(Input::get('echostr')){
          $weChat->receive();//如果已经匹配过，就直接处理发送过来的消息
      }else{
          $weChat ->checkSignature();//匹配公众号的接口配置信息
      }*/
  }
}
