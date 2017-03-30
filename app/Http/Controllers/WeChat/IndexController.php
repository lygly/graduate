<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\Customer;
use App\Http\Model\ProductPhoto;
use App\Library\WeChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //首页
    public function index(){
     $data = ProductPhoto::where('isBanner',1)->get();
    $field = ProductPhoto::join('p_product','p_product.id','=','p_productphoto.productId')
         ->join('p_productproperty','p_productproperty.productId','=','p_productphoto.productId')
         ->where('p_productphoto.isBanner','0')
         ->select('p_productphoto.*','p_product.productName','p_productproperty.unitPrice')
         ->get();
        return view('wechat.product_center',compact('data','field'));
    }
    public function detail($productId){
        $data = ProductPhoto::join('p_product','p_product.id','=','p_productphoto.productId')
            ->join('p_productproperty','p_productproperty.productId','=','p_productphoto.productId')
            ->where('p_productphoto.productId',$productId)
            ->select('p_productphoto.*','p_product.productName','p_product.remark','p_productproperty.unitPrice')
            ->first();
       // dd($data);
        return view('wechat.product_detail',compact('data'));
    }
    //个人中心
    public function profile(){
        $open_id = session('open_id');
        if (empty($open_id)){
            $weChat =new WeChat();
            $weChat->oauth();
            $open_id = session('open_id');
        }
       dd($open_id);
        $data = Customer::where('openId',$open_id)->get();
        dd($data);
        return view('wechat.user_profile',compact('data'));
    }
    //购物车第一个页面
    public function cart_step1(){
        return view('wechat.cart_step1');
    }
    //关于我们
    public function about(){
        return view('wechat.seller_about');
    }
}
