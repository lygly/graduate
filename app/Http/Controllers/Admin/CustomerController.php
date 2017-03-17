<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends CommonController
{
    // get admin/customer   get方式过来的 后面是地址  全部用户信息列表
    public function index(){
       $data = Customer::orderBy('createDate','desc')->paginate(4);
        return view('admin.customer.index',compact('data'));
    }
    //get admin/customer/create  添加用户信息
    public function create(){
        $data = (new Dictionary)->question();  //实例化类 并指向question方法
        return view('admin.customer.add',compact('data'));
    }
    //post admin/customer 添加用户信息提交方法
    public function store(){
        $input = Input::except('_token');
        $input['createDate'] = time();//自动添加时候的时间
        //填写规则
        $rules = [
            'question'=>'required',
            'answer'=>'required'
        ];
        //填写提示信息
        $message = [
            'question.required'=>'问题不能为空',
            'answer.required'=>'答案不能为空'
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = Customer::create($input);
            if($re){
                return redirect('admin/customer');
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }
    //get admin/customer/{customer}/edit   编辑用户信息
    public function edit($id){
        $data = (new Dictionary)->question();  //实例化类 并指向question方法
        $field = Customer::find($id);
        return view('admin.customer.edit',compact('data','field'));
    }
    //put admin/customer/{customer}   更新用户信息
    public function update($id){
        $input = Input::except('_token','_method');
        $re = Customer::where('id',$id) ->update($input);
        if($re){
            return redirect('admin/customer');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
    //delete admin/customer/{customer}  删除单个用户信息
    public function destroy($id){
        $re = Customer::where('id',$id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'用户信息删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'用户信息删除失败，请稍后重试S！'
            ];
        }
        return $data;
    }
    //get admin/customer/{customer}   显示单个用户信息信息
    public function show(){

    }
}
