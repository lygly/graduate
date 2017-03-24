<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\ProductPhoto;
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
            ->select('p_productphoto.*','p_product.productName','p_productproperty.unitPrice')
            ->first();
       // dd($data);
        return view('wechat.product_detail',compact('data'));
    }
}
