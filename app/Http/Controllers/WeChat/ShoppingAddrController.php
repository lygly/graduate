<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\ShoppingAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ShoppingAddrController extends Controller
{
    // get wechat/shopAddr   get方式过来的 后面是地址
    public function index(){
    }
    //get wechat/shopAddr/create
    public function create(){
        return view('wechat.shopAddr.add');
    }
    //post wechat/shopAddr
    public function store(){
        $input = Input::get();
        $input['createDate'] = time();//自动添加时候的时间
        $customer_id = $input['customerId'];
        $re = ShoppingAddress::create($input);
        if ($re){
            return redirect('wechat/shopAddr/'.$customer_id);
        }else{
            return back()->with("errors","数据更新失败，请稍后重试");
        }
    }
    //get wechat/shopAddr/{about}/edit
    public function edit($id){
        $field = ShoppingAddress::find($id);
        return view('wechat.shopAddr.edit',compact('field'));
    }
    //put wechat/shopAddr/{about}
    public function update($id){
        $input = Input::except('_method');
        $customer_id = $input['customerId'];
        $re = ShoppingAddress::where('id',$id) ->update($input);
        if($re){
            return redirect('wechat/shopAddr/'.$customer_id);
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
    //delete wechat/shopAddr/{about}  删除单个
    public function destroy($id){
        $re = ShoppingAddress::where('id',$id)->delete();
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
    //get wechat/shopAddr/{about}   显示单个
    public function show($customer_id){
        $data = ShoppingAddress::orderBy('createDate','desc')->get();
        session(['customer_id'=>$customer_id]); //把customerID写入session
        return view('wechat.shopAddr.index',compact('data'));
    }
}
