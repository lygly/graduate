<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once app_path().'/org/code/Code.class.php'; //引入验证码扩展文件

class LoginController extends CommonController
{
   public function login(){
       if ($input = Input::all()){  //验证是否是正常提交过来的数据
           $code = new \Code();     //实例化验证码类
           $_code = $code->get();    //获取当前验证码
           if (strtoupper($input['code'])!=$_code){  //验证验证码是否正确
               return back()->with('msg','验证码错误');
           }
           $user = User::first(); //从数据库中取出一项数据
           if ($user->user_name != $input['user_name']|| Crypt::decrypt($user->user_pass) != $input['user_pass']){
               return back()->with('msg','用户名或密码错误');
           }
           session(['user'=>$user]);
          // dd(session('user'));
              return redirect('admin'); //跳转到后台欢迎页面

       }else{
           return view('admin.login');    //如果验证未通过则返回登录页面
       }

   }
    public function quit(){
       session(['user'=>null]);
       return redirect('admin/login');
    }
   public function code(){
       $code = new \Code(); //实例化验证码类
       $code->make();  //创建验证码
   }

}
