<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\ShopCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ShopCartController extends Controller
{
    // get wechat/shopCart   get方式过来的 后面是地址  全部关于我们列表
    public function index(){
        $customer_id = session('customer_id');
        // dd($customer_id);

        $data = ShopCart::where('customerId',$customer_id)->orderBy('createDate','desc')->get();
      // dd($data);
        return view('wechat.shopCart.cart_step1',compact('data'));
    }
    //get wechat/shopCart/create  添加关于我们
    public function create(){
        return view('wechat.shopCart.add');
    }
    //post wechat/shopCart 添加关于我们提交方法
    public function store(){
        $input = Input::get();
        $input['createDate'] = time();//自动添加时候的时间
        $open_id = $input['openId'];
        $re = ShopCart::create($input);
        if ($re){
            return redirect('wechat/shopCart/'.$open_id);
        }else{
            return back()->with("errors","数据更新失败，请稍后重试");
        }
    }
    //get wechat/shopCart/{about}/edit   添加商品到购物车
    public function edit($id){
        $field = ShopCart::find($id);
        return view('wechat.shopCart.edit',compact('field'));
    }
    //put wechat/shopCart/{about}   更新关于我们
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
    //delete wechat/shopCart/{about}  删除单个关于我们
    public function destroy($id){
        $re = ShopCart::where('id',$id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'删除失败，请稍后重试！'
            ];
        }
        return $data;
    }
    //get wechat/shopCart/{about}   显示单个关于我们信息
    public function show($productId){
        $customer_id = session('customer_id');
       // dd($customer_id);

        $data = ShopCart::where('customerId',$customer_id)->orderBy('createDate','desc')->paginate(5);
        dd($data);
        return view('wechat.shopCart.cart_step1',compact('data'));
    }
}
