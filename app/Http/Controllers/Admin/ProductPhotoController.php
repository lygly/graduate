<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\ProductPhoto;
use App\Http\Model\ProductSpec;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ProductPhotoController extends CommonController
{
    // get admin/productPhoto   get方式过来的 后面是地址  全部产品图列表
    public function index(){

    }
    //get admin/productPhoto/create  添加产品图
    public function create(){
        return view('admin.productPhoto.add');
    }
    //post admin/productPhoto 添加产品图提交方法
    public function store(){
        $input = Input::except('_token','PHPSESSID');
        $input['createDate'] = time();//自动添加产品图添加时候的时间
        $productId = $input['productId'];
        //填写规则
        $rules = [
            'picUrl'=>'required'   //字段必填,
        ];
        //填写提示信息
        $message = [
            'picUrl.required'=>'图片不能为空',
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = ProductPhoto::create($input);
            if ($re){
                return redirect('admin/productPhoto/'.$productId);  //返回到产品图列表页面
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);  //返回错误信息
        }
    }
    //get admin/productPhoto/{productPhoto}/edit   修改产品图
    public function edit($id){
        $field =  ProductPhoto::find($id);
        return view('admin.productPhoto.edit',compact('field'));

    }
    //put admin/productPhoto/{productPhoto}   更新产品图
    public function update($id){
        $input = Input::except('_token','_method');//接收网页更改的数据
        $input['createDate'] = time();//自动添加产品图添加时候的时间
        $productId = $input['productId'];
        //dd($input);
        $re = ProductPhoto::where('id',$id) ->update($input);
        if($re){
            return redirect('admin/productPhoto/'.$productId);
        }else{
            return back()->with('errors','产品图更新失败，请稍后重试！');
        }

    }
    //delete admin/productPhoto/{productPhoto}  删除单个产品图
    public function destroy($id){
        $re = ProductPhoto::where('id',$id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'产品图删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'产品图删除失败，请稍后重试S！'
            ];
        }
        return $data;

    }
    //get admin/productPhoto/{productPhoto}   显示单个产品图信息
    public function show($id){
        $data = ProductPhoto::where('productId',$id)
            ->orderBy('createDate','desc')
            ->paginate(5);
        session(['productId'=>$id]);
        return view('admin.productPhoto.index',compact('data'));

    }
}
