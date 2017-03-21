<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductPhotoController extends CommonController
{
    // get admin/productPhoto   get方式过来的 后面是地址  全部产品图列表
    public function index(){
        $data = ProductPhoto::orderBy('createDate','desc')->paginate(5); //读取数据按ID倒叙显示并且每一页显示5条记录
        return view('admin.productPhoto.index',compact('data'));
    }
    //get admin/productPhoto/create  添加产品图
    public function create(){
        $data = Dictionary::where('pId','1')->orderBy('sort','asc')->get(); //读取分类栏目
        return view('admin.productPhoto.add',compact('data'));
    }
    //post admin/productPhoto 添加产品图提交方法
    public function store(){
        $input = Input::except('_token','PHPSESSID');
        //dd($input);
        $picUrl['pic'] = $input['pic'];

        unset($input['pic']);//删除
        $input['createPerson'] = 'admin';
        $input['createDate'] = time();//自动添加产品图添加时候的时间
        //dd($picUrl);
        //填写规则
        $rules = [
            'productPhotoCode'=>'required'   //字段必填,
        ];
        //填写提示信息
        $message = [
            'productPhotoCode.required'=>'产品号不能为空',
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = ProductPhoto::create($input);
            $re_pic = ProductPhotoPhoto::create($picUrl);
            if ($re && $re_pic){
                return redirect('admin/productPhoto');  //返回到产品图列表页面
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);  //返回错误信息
        }
    }
    //get admin/productPhoto/{productPhoto}/edit   修改产品图
    public function edit($id){
        $data = Dictionary::where('pId','1')->orderBy('sort','asc')->get(); //读取分类栏目
        $field =  ProductPhoto::find($id);
        return view('admin.productPhoto.edit',compact('field','data'));

    }
    //put admin/productPhoto/{productPhoto}   更新产品图
    public function update($id){
        $input = Input::except('_token','_method');//接收网页更改的数据
        unset($input['pic']);//删除
        $input['createPerson'] = 'admin';
        $input['createDate'] = time();//自动添加产品图添加时候的时间
        $re = ProductPhoto::where('id',$id) ->update($input);
        if($re){
            return redirect('admin/productPhoto');
        }else{
            return back()->with('errors','产品图更新失败，请稍后重试！');
        }

    }
    //delete admin/productPhoto/{productPhoto}  删除单个分类
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
    //get admin/category/{category}   显示单个分类信息
    public function show(){

    }
}
