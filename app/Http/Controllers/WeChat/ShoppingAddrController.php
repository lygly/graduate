<?php

namespace App\Http\Controllers\WeChat;

use App\Http\Model\ShoppingAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ShoppingAddrController extends Controller
{
    // get wechat/shopAddr   get方式过来的 后面是地址  全部关于我们列表
    public function index(){
       /* $data = ShoppingAddress::orderBy('createDate','desc')->paginate(5);
        return view('wechat.shopAddr.index',compact('data'));*/
    }
    //get wechat/shopAddr/create  添加关于我们
    public function create(){
        return view('wechat.shopAddr.add');
    }
    //post wechat/shopAddr 添加关于我们提交方法
    public function store(){
        $input = Input::get();
      // dd($input);
        $input['createDate'] = time();//自动添加时候的时间
        $open_id = $input['openId'];
        $re = ShoppingAddress::create($input);
        if ($re){
            return redirect('wechat/shopAddr/'.$open_id);
        }else{
            return back()->with("errors","数据更新失败，请稍后重试");
        }
    }
    //get wechat/shopAddr/{about}/edit   编辑关于我们
    public function edit($id){
        $field = ShoppingAddress::find($id);
        return view('wechat.shopAddr.edit',compact('field'));
    }
    //put wechat/shopAddr/{about}   更新关于我们
    public function update($id){
        $input = Input::except('_method');
        // dd($input);
        $open_id = $input['openId'];
        $re = ShoppingAddress::where('id',$id) ->update($input);
        if($re){
            return redirect('wechat/shopAddr/'.$open_id);
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
    //delete wechat/shopAddr/{about}  删除单个关于我们
    public function destroy($id){
        $re = ShoppingAddress::where('id',$id)->delete();
        if ($re){
           /* $data = [
                'status'=>0,
                'msg'=>'关于我们删除成功！'
            ];*/
            return redirect('wechat/shopAddr');
        }else{
            $data = [
                'status'=>1,
                'msg'=>'关于我们删除失败，请稍后重试S！'
            ];
        }
        return $data;
    }
    //get wechat/shopAddr/{about}   显示单个关于我们信息
    public function show($open_id){
        $data = ShoppingAddress::orderBy('createDate','desc')->paginate(5);
        session(['open_id'=>$open_id]); //把openID写入session
        return view('wechat.shopAddr.index',compact('data'));
    }
}
