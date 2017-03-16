<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class IndexController extends CommonController
{
    public function index(){
        return view('admin.index');
    }
    public function info(){
        return view('admin.info');
    }
    //更改超级管理员密码
    public function pass(){
        if ($input = Input::get()){
            //密码填写规则
            $rules = [
                'password'=>'required|between:6,20|confirmed',
            ];
            //密码填写提示信息
            $message = [
              'password.required'=>'新密码不能为空',
              'password.between'=>'新密码必须在6到20位之间',
              'password.confirmed'=>'新密码和确认密码不一致',
            ];
            //表单提交验证
            $validator = Validator::make($input,$rules,$message);
            //如果新密码填写通过了验证
            if ($validator->passes()){
                $user = User::first();  //从数据库中取出用户信息.
               $_password =  Crypt::decrypt($user->user_pass);
              if ($input['password_o']==$_password){  //如果输入的密码和数据库里面的密码相同
                  $user->user_pass = Crypt::encrypt($input['password']);   //加密新密码并替换旧密码
                  $user->update();   //修改密码
                  return back()->with('errors','密码修改成功！');
              }else{
                  return back()->with('errors','原密码错误');
              }
            }else{
                return back()->withErrors($validator);  //返回错误信息
            }

        }else{
            return view('admin.pass');
        }
    }
}
