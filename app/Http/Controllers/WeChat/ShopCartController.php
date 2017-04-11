<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\Customer;
use App\Http\Model\Order;
use App\Http\Model\OrderDetail;
use App\Http\Model\ShopCart;
use App\Http\Model\ShoppingAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ShopCartController extends Controller
{
    // get wechat/shopCart   get方式过来的 后面是地址
    public function index(){
        $customer_id = session('customer_id');
        $data = ShopCart::where('customerId',$customer_id)->orderBy('createDate','desc')->get();
        return view('wechat.shopCart.cart_step1',compact('data'));
    }
    //get wechat/shopCart/create  点击按钮数量增加
    public function create(){
      $input = Input::get();
      $account = ShopCart::where('productId',$input['productId'])->first();
      $account->account = $input['account'];
      $account->update();
    }
    //post wechat/shopCart 点击按钮数量减少
    public function store(){
    $input = Input::get();
    $account = ShopCart::where('productId',$input['productId'])->first();
    $account->account = $input['account'];
    $account->update();
    }
    //get wechat/shopCart/{about}/edit 显示所有可选择的地址
    public function edit($customer_id){
        $data = ShoppingAddress::where('customerId',$customer_id)->orderBy('createDate','desc')->get();
        session(['customer_id'=>$customer_id]); //把customerID写入session
        return view('wechat.shopCartAddr',compact('data'));
    }
    //提交产品 跳转到下一页
    public function addr($customer_id){
        $input = Input::except('_method');
          $addr_id = $input['addrId'];
         session(['addrId'=>$addr_id]);
        //如果选择了地址则显示选择的地址否则显示默认
        if ($addr_id){
            $data = ShoppingAddress::find($addr_id);
            $productId = session('productId');
        }else{
            $data = ShoppingAddress::where('customerId',$customer_id)->orderBy('createDate','asc')->first();
            $productId = $input['productId'];//产品ID数组
            session(['productId'=>$productId,'sumMoney'=>$input['sumMoney'],'addrId'=>$data->id]);
        }
        //查出选择了的商品
        foreach ($productId as $k=>$v){
            $goods[$k] = ShopCart::where('productId',$v)->first();
        }
        return view('wechat.shopCart.cart_step2',compact('goods','data'));
    }
    //提交订单 跳转到下一页
    public function order(){
        $input = Input::get();
        //订单主表数据
        $orderMain['customerId'] = $input['customerId'];
        $orderMain['sumMoney'] = $input['sumMoney'];
        $orderMain['payment'] = $input['payment'];
        $orderMain['addressId'] = $input['addressId'];
        $orderMain['orderCode'] = date("YmdHis").rand(100,999); //订单编号
        $orderMain['orderDate'] =time();
        $orderMain['actionDate'] =time();
        $orderMain['openId'] =session('open_id');
        //写入订单主表
        $re = Order::create($orderMain);
        //订单明细表数据
       // $orderDetail['oderId'] = $orderMain['orderCode'];
        $productId = $input['productId'];
        $uintPrice= $input['uintPrice'];
        $account = $input['account'];
        $len = sizeof($input['productId']);
        for($i = 0; $i<$len;$i++){
            $orderDetail['orderId'] = $orderMain['orderCode'];
            $orderDetail['productId'] = $productId[$i];
            $orderDetail['uintPrice'] = $uintPrice[$i];
            $orderDetail['account'] = $account[$i];
            $detailRe = OrderDetail::create($orderDetail);
        }
        if($re && $detailRe){
            return view('wechat.shopCart.cart_step3');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
//支付页面
    public function pay(){
        return view('wechat.shopCart.cart_step4');
    }

    //put wechat/shopCart/{about}  添加商品到购物车
    public function update($productId){
        $input = Input::except('_method');
        $customer_id = session('customer_id');
        $open_id = session('open_id');
        $imgUrl = $input['imgUrl'];
        $productName = $input['productName'];
        $unitPrice = $input['unitPrice'];
        $createDate = time();
        //  dd($input);
        /* insert into p_shopcart(customerId,openid,productId,imgUrl,productName,unitPrice,uint,createDate)
 VALUES(6,'',3,'uploads/20170322111036821.png','腰带药片', 89.00,'元',now())on duplicate key update account=account+1;*/
        $sqlStr="insert into p_shopcart(customerId,openid,productId,imgUrl,productName,unitPrice,uint,createDate,account)VALUES($customer_id,'$open_id',$productId,'$imgUrl','$productName', $unitPrice,'元',$createDate,1)on duplicate key update account=account+1";
        $re = DB::insert($sqlStr);
        if($re){
            return redirect('wechat/shopCart');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
    //delete wechat/shopCart/{about}  删除单个商品
    public function destroy($id){
        ShopCart::where('id',$id)->delete();
    }
    //get wechat/shopCart/{about}   删除所有商品
    public function show($id){
        DB::table('p_shopcart')->truncate(); //清空表
    }
}
