<?php

namespace App\Http\Controllers\WeChat;

use App\Library\WeChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class WeChatController extends Controller
{
    //
   /* public function __construct(WeChat $weChat)
    {
        $this->wechat = $weChat;
    }*/

    public function serve(){

        $weChat =new WeChat();
        $echoStr = Input::get('echostr');//获取返回的echostr字符串
        if(!isset($echoStr)){
            $weChat->receive();//如果已经匹配过，就直接处理发送过来的消息
        }else{
            $weChat ->checkSignature();//匹配公众号的接口配置信息
        }
        $weChat->menu();//自定义菜单
  }
}
