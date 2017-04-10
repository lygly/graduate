<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Order;
use App\Http\Model\OrderDetail;
use App\Http\Model\ProductProperty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class OrderController extends CommonController
{
    //获取订单列表
    public function index(){
        $data =Order::join('u_customer','u_customer.id','=','p_ordermain.customerId')
            ->join('u_address','u_address.id','=','p_ordermain.addressId')
            ->select('p_ordermain.*','u_customer.nickName','u_address.*')
            ->orderBy('orderDate','desc')->paginate(8);//读取订单列表并每一页显示8条记录
        return view('admin.order.index',compact('data'));
    }
    //订单明细
    public function detail(){
        $input = Input::get();
        $orderId = $input['orderCode'];
        $data = OrderDetail::join('p_product','p_product.id','=','p_orderdetail.productId')
            ->join('p_productdetail','p_orderdetail.productId','=','p_productdetail.productId')
            ->where('orderId',$orderId)
            ->select('p_orderdetail.*','p_product.productName','p_productdetail.propertyId')
            ->get();
       // $propertyId = $data->propertyId;
       // $field = ProductProperty::where('id',$propertyId)->
        return view('admin.order.orderDetail',compact('data'));
    }
}
