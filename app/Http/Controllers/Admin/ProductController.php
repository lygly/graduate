<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Dictionary;
use App\Http\Model\Product;
use App\Http\Model\ProductPhoto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ProductController extends CommonController
{
    // get admin/product   get方式过来的 后面是地址  全部商品列表
    public function index(){
        $data = Product::orderBy('createDate','desc')->paginate(5); //读取数据按ID倒叙显示并且每一页显示5条记录
        return view('admin.product.index',compact('data'));
    }
    //get admin/product/create  添加商品
    public function create(){
        $data = Dictionary::where('pId','1')->orderBy('sort','asc')->get(); //读取分类栏目
        return view('admin.product.add',compact('data'));
    }
    //post admin/product 添加商品提交方法
    public function store(){
        $input = Input::except('_token','PHPSESSID');
        //dd($input);
        $picUrl['pic'] = $input['pic'];

        unset($input['pic']);//删除
        $input['createPerson'] = 'admin';
        $input['createDate'] = time();//自动添加商品添加时候的时间
       //dd($picUrl);
        //填写规则
        $rules = [
            'productCode'=>'required'   //字段必填,
        ];
        //填写提示信息
        $message = [
            'productCode.required'=>'产品号不能为空',
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = Product::create($input);
            $re_pic = ProductPhoto::create($picUrl);
            if ($re && $re_pic){
                return redirect('admin/product');  //返回到商品列表页面
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);  //返回错误信息
        }
    }
    //get admin/product/{product}/edit   修改商品
    public function edit($art_id){
        $data = (new Category)->tree(); //读取分类栏目
        //$data = Category::where('cate_pid',0)->get();
        $field =  Product::find($art_id);
        return view('admin.product.edit',compact('field','data'));

    }
    //put admin/product/{product}   更新商品
    public function update($art_id){
        $input = Input::except('_token','_method');//接收网页更改的数据
        $re = Product::where('art_id',$art_id) ->update($input);
        if($re){
            return redirect('admin/product');
        }else{
            return back()->with('errors','商品更新失败，请稍后重试！');
        }

    }
    //delete admin/product/{product}  删除单个分类
    public function destroy($art_id){
        $re = Product::where('art_id',$art_id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'商品删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'商品删除失败，请稍后重试S！'
            ];
        }
        return $data;

    }
    //get admin/category/{category}   显示单个分类信息
    public function show(){

    }
}
