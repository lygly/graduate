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
            ->orderBy('orderDate','desc')->paginate(5);//读取订单列表并每一页显示8条记录
        return view('admin.order.index',compact('data'));
    }
    //订单明细
    public function detail(){
        $input = Input::get();
        $orderId = $input['orderCode'];
        /*SELECT * FROM p_orderdetail JOIN p_product ON p_orderdetail.productId = p_product.id WHERE orderId = "20170417102237606";*/
        $data = OrderDetail::join('p_product','p_product.id','=','p_orderdetail.productId')
            ->where('orderId',$orderId)
            ->select('p_orderdetail.*','p_product.productName')
            ->get();
        //dd($data);
        return view('admin.order.orderDetail',compact('data'));
    }
    //删除订单
    public function delete($orderCode){
        $re = Order::where('orderCode',$orderCode)->delete();
        dd($re);
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'订单删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'订单删除失败，请稍后重试！'
            ];
        }
        return $data;
    }
}
