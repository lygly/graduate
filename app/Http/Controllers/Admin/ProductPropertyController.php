<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductPropertyController extends CommonController
{
    // get admin/productProperty   get方式过来的 后面是地址  全部商品属性列表
    public function index(){
        $data = ProductProperty::orderBy('createDate','desc')->paginate(5); //读取数据按ID倒叙显示并且每一页显示5条记录
        return view('admin.productProperty.index',compact('data'));
    }
    //get admin/productProperty/create  添加商品属性
    public function create(){
        $data = (new Category)->tree(); //读取分类栏目
        return view('admin.productProperty.add',compact('data'));
    }
    //post admin/productProperty 添加商品属性提交方法
    public function store(){
        $input = Input::except('_token','PHPSESSID');
        $input['art_time'] = time();//自动添加商品属性添加时候的时间
        //填写规则
        $rules = [
            'art_title'=>'required',   //art_title 字段必填
            'art_content'=>'required',
        ];
        //填写提示信息
        $message = [
            'art_title.required'=>'商品属性标题不能为空',
            'art_content.required'=>'商品属性内容不能为空',
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = ProductProperty::create($input);
            if ($re){
                return redirect('admin/productProperty');  //返回到商品属性列表页面
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);  //返回错误信息
        }
    }
    //get admin/productProperty/{productProperty}/edit   修改商品属性
    public function edit($art_id){
        $data = (new Category)->tree(); //读取分类栏目
        //$data = Category::where('cate_pid',0)->get();
        $field =  ProductProperty::find($art_id);
        return view('admin.productProperty.edit',compact('field','data'));

    }
    //put admin/productProperty/{productProperty}   更新商品属性
    public function update($art_id){
        $input = Input::except('_token','_method');//接收网页更改的数据
        $re = ProductProperty::where('art_id',$art_id) ->update($input);
        if($re){
            return redirect('admin/productProperty');
        }else{
            return back()->with('errors','商品属性更新失败，请稍后重试！');
        }

    }
    //delete admin/productProperty/{productProperty}  删除单个分类
    public function destroy($art_id){
        $re = ProductProperty::where('art_id',$art_id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'商品属性删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'商品属性删除失败，请稍后重试S！'
            ];
        }
        return $data;

    }
    //get admin/category/{category}   显示单个分类信息
    public function show(){

    }
}
