<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload()
    {
        $file = Input::file('Filedata');  //获取文件信息的方法
        if ($file -> isValid()){
           // $realPath = $file ->getRealPath(); //获取临时文件的绝对路径
            $entension = $file ->getClientOriginalExtension(); //获取原始文件的后缀名
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension; //重命名文件 加上年月日和三个随机数
            $path = $file -> move(base_path().'\uploads',$newName);//移动文件到指定路径并且给文件重命名，
            //返回文件路径给当前页面
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }
}
