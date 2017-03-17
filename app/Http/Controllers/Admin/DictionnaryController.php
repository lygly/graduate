<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DictionnaryController extends CommonController
{
    // get admin/category   get方式过来的 后面是地址  全部分类列表
    public function index(){
        return view('admin.dictionnary.index');
    }
    //get admin/category/create  添加分类
    public function create(){
        $data = [];
        return view('admin.dictionnary.add',compact('data'));
    }
    //post admin/category 添加分类提交方法
    public function store(){

    }
    //get admin/category/{category}/edit   编辑分类
    public function edit($id){
        return view('admin.dictionnary.edit');
    }
    //put admin/category/{category}   更新分类
    public function update($id){

    }
    //delete admin/category/{category}  删除单个分类
    public function destroy($id){

    }
    //get admin/category/{category}   显示单个分类信息
    public function show(){

    }
}
