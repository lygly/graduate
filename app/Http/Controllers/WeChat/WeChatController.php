<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\Customer;
use App\Library\WeChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

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
       // $weChat->menu();//自定义菜单
       /* $userInfo = json_decode($weChat->unionId(),true); //true 则转换为数组 默认转换为对象
       // $userInfo = $this->object2array($userInfo); //把PHP对象转换成PHP数组
        //忽略这些字段
        unset($userInfo['subscribe']);
        unset($userInfo['language']);
        unset($userInfo['groupid']);
        unset($userInfo['tagid_list']);
        $re = Customer::create($userInfo); //如果openID 没有则插入到数据库*/

  }
//  把PHP对象转换成数组函数
   /* function object2array($object) {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $array[$key] = $value;
            }
        }
        else {
            $array = $object;
        }
        return $array;
    }*/

}
