<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\Customer;
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
           //dd($input);
           $addr_id = $input['addrId'];
        //如果选择了地址则显示选择的地址否则显示默认
        if ($addr_id){
            $data = ShoppingAddress::find($addr_id);
        }else{
            $data = ShoppingAddress::where('customerId',$customer_id)->orderBy('createDate','asc')->first();
        }

        // dd($data);
        return view('wechat.shopCart.cart_step2',compact('data'));
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
