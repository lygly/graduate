<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Dictionary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class DictionaryController extends CommonController
{
    // get admin/category   get方式过来的 后面是地址  全部分类列表
    public function index(){
        $categorys = (new Dictionary)->tree();  //实例化类 并指向tree方法
        return view('admin.dictionary.index')->with('data',$categorys);
    }
    public function changeOrder(){
        $input = Input::get();
        $cate = Dictionary::find($input['id']);
        $cate->sort = $input['sort'];
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
        $data = Dictionary::where('pId',0)->get();
        return view('admin.dictionary.add',compact('data'));
    }
    //post admin/category 添加分类提交方法
    public function store(){
        $input = Input::except('_token');
        //填写规则
        $rules = [
            'names'=>'required',
            'isDel'=>'required',
            'isBasic'=>'required'
        ];
        //填写提示信息
        $message = [
            'names.required'=>'名称不能为空',
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = Dictionary::create($input);
            if($re){
                return redirect('admin/dictionary');
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }
    //get admin/category/{category}/edit   编辑分类
    public function edit($id){
        $data=Dictionary::where("pId",0)->get(); //分类
        $field = Dictionary::find($id);
        return view('admin.dictionary.edit',compact('data','field'));
    }
    //put admin/category/{category}   更新分类
    public function update($id){
        $input = Input::except('_token','_method');
        $re = Dictionary::where('id',$id) ->update($input);
        if($re){
            return redirect('admin/dictionary');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
    //delete admin/category/{category}  删除单个分类
    public function destroy($id){
        $re = Dictionary::where('id',$id)->delete();
        Dictionary::where('pId',$id)->update(['pId'=>0]); //如果删除的是顶级分类 则把他下面所有的子分类都变成顶级分类
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
