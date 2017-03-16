<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends CommonController
{
    //获取订单列表
    public function index(){
        $data =Order::orderBy('createDate','desc')->paginate(8);//读取订单列表并每一页显示8条记录
        return view('admin.order.index',compact('data'));
    }
}
