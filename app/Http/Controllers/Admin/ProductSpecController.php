<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Dictionary;
use App\Http\Model\ProductSpec;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ProductSpecController extends CommonController
{
    // get admin/productSpec   get方式过来的 后面是地址  全部规格定义列表
    public function index(){
        $data = ProductSpec::join('sys_dictionary','sys_dictionary.id','=','p_productspec.productTypeId')
            ->select('p_productspec.*','sys_dictionary.names')
            ->orderBy('createDate','desc')->paginate(5);
        return view('admin.productSpec.index',compact('data'));
    }
    //get admin/productSpec/create  添加规格定义
    public function create(){
        $data = Dictionary::where('pId',1)->orderBy('sort','asc')->get();
        return view('admin.productSpec.add',compact('data'));
    }
    //post admin/productSpec 添加规格定义提交方法
    public function store(){
        $input = Input::except('_token');
        // dd($input);
        $input['createPerson'] = 'admin';
        $input['createDate'] = time();//自动添加时候的时间
        //填写规则
        $rules = [
            'spec'=>'required',
        ];
        //填写提示信息
        $message = [
            'spec.required'=>'规格不能为空'
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = ProductSpec::create($input);
            if($re){
                return redirect('admin/productSpec');
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }
    //get admin/productSpec/{productSpec}/edit   编辑规格定义
    public function edit($id){
         $data = Dictionary::where('pId',1)->orderBy('sort','asc')->get();//查询类别列表
        $field = ProductSpec::find($id);
        return view('admin.productSpec.edit',compact('field','data'));
    }
    //put admin/productSpec/{productSpec}   更新规格定义
    public function update($id){
        $input = Input::except('_token','_method');
        // dd($input);
        $re = ProductSpec::where('id',$id) ->update($input);
        if($re){
            return redirect('admin/productSpec');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
    //delete admin/productSpec/{productSpec}  删除单个规格定义
    public function destroy($id){
        $re = ProductSpec::where('id',$id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'规格定义删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'规格定义删除失败，请稍后重试S！'
            ];
        }
        return $data;
    }
    //get admin/productSpec/{productSpec}   显示单个规格定义信息
    public function show(){

    }
}
