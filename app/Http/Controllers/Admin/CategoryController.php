<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    // get admin/category   get方式过来的 后面是地址  全部分类列表
    public function index(){
        $categorys = (new Category)->tree();  //实例化类 并指向tree方法
        return view('admin.category.index')->with('data',$categorys);
    }

    public function changeOrder(){
        $input = Input::get();
        $cate = Category::find($input['cate_id']);
        $cate->cate_order = $input['cate_order'];
        $re = $cate->update();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'分类排序更新成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'分类排序更新失败，请稍后重试S！'
            ];
        }
        return $data;
    }
    //get admin/category/create  添加分类
    public function create(){
        $data = Category::where('cate_pid',0)->get();
       return view('admin.category.add',compact('data'));
    }
    //post admin/category 添加分类提交方法
    public function store(){
        $input = Input::except('_token');
       // if ($input = Input::get()){
            //填写规则
            $rules = [
                'cate_name'=>'required',
            ];
            //填写提示信息
            $message = [
                'cate_name.required'=>'分类名称不能为空',
            ];
            //表单提交验证
            $validator = Validator::make($input,$rules,$message);
            //如果填写通过了验证
            if ($validator->passes()){
                $re = Category::create($input);
                if($re){
                    return redirect('admin/category');
                }else{
                    return back()->with('errors','数据更新失败，请稍后重试！');
                }

                }else{
                    return back()->withErrors($validator);
                }
            }
    //get admin/category/{category}/edit   编辑分类
    public function edit($cate_id){
       $data = Category::where('cate_pid',0)->get();
       $field =  Category::find($cate_id);
       return view('admin.category.edit',compact('field','data'));

    }
    //put admin/category/{category}   更新分类
    public function update($cate_id){
        $input = Input::except('_token','_method');
        $re = Category::where('cate_id',$cate_id) ->update($input);
        if($re){
            return redirect('admin/category');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }

    }
    //delete admin/category/{category}  删除单个分类
    public function destroy($cate_id){
         $re = Category::where('cate_id',$cate_id)->delete();
         Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]); //如果删除的是顶级分类 则把他下面所有的子分类都变成顶级分类
         if ($re){
             $data = [
                 'status'=>0,
                 'msg'=>'分类删除成功！'
             ];
         }else{
             $data = [
                 'status'=>1,
                 'msg'=>'分类删除失败，请稍后重试S！'
             ];
         }
        return $data;

    }

    //get admin/category/{category}   显示单个分类信息
    public function show(){

    }



}
