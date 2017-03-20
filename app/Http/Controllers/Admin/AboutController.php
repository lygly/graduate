<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    // get admin/about   get方式过来的 后面是地址  全部关于我们列表
    public function index(){
        $data = About::orderBy('createDate','desc')->paginate(4);
        return view('admin.about.index',compact('data'));
    }
    //get admin/about/create  添加关于我们
    public function create(){
        // $data = (new Dictionary)->question();  //实例化类 并指向question方法
        return view('admin.about.add');
    }
    //post admin/about 添加关于我们提交方法
    public function store(){
        $input = Input::except('_token');
        // dd($input);
        $input['createPerson'] = 'admin';
        $input['createDate'] = time();//自动添加时候的时间
        //填写规则
        $rules = [
            'project'=>'required',
        ];
        //填写提示信息
        $message = [
            'project.required'=>'主题不能为空'
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = About::create($input);
            if($re){
                return redirect('admin/about');
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }
    //get admin/about/{about}/edit   编辑关于我们
    public function edit($id){
        // $data = (new Dictionary)->question();  //实例化类 并指向question方法
        $field = About::find($id);
        return view('admin.about.edit',compact('field'));
    }
    //put admin/about/{about}   更新关于我们
    public function update($id){
        $input = Input::except('_token','_method');
        // dd($input);
        $re = About::where('id',$id) ->update($input);
        if($re){
            return redirect('admin/about');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
    //delete admin/about/{about}  删除单个关于我们
    public function destroy($id){
        $re = About::where('id',$id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'关于我们删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'关于我们删除失败，请稍后重试S！'
            ];
        }
        return $data;
    }
    //get admin/about/{about}   显示单个关于我们信息
    public function show(){

    }
}
