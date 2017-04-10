<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\Customer;
use App\Http\Model\ProductPhoto;
use App\Http\Model\ShoppingAddress;
use App\Library\WeChat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class IndexController extends Controller
{
    //首页
    public function index(){
         $open_id = session('open_id');
       if (empty($open_id)){
           $weChat =new WeChat();
           $weChat->oauth();
           $open_id = session('open_id');
       }
        // dd($open_id);
      //  $open_id = "okyhUwNdRkU577OWH3XHqbddxBao";
        $customer = Customer::select('id')->where('openId',$open_id)->first();
        $customer_id = $customer->id;  //获取客户ID
        //dd($customer_id);
        session(['customer_id'=>$customer_id]);
        session(['open_id'=>$open_id]);
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
        $customer_id = session('customer_id');
        $data = Customer::find($customer_id);
       //dd($data);
        return view('wechat.user_profile',compact('data'));
    }
    //更新个人资料
    public function updateProfile($customer_id){
        $input = Input::get();
        $input['birthday'] = strtotime($input['birthday']); //把日期转换为时间戳
        $re = Customer::where('id',$customer_id)->update($input);
        if ($re){
            return redirect('wechat/profile');
        }else{
            return back()->with("errors","数据更新失败，请稍后重试！");
        }
    }
    //关于我们
    public function about(){
        return view('wechat.seller_about');
    }
}
