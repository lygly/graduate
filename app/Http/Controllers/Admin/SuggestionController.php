<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Suggestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SuggestionController extends CommonController
{
    // get admin/suggestion   get方式过来的 后面是地址  全部意见反馈列表
    public function index(){
        $data = Suggestion::join('u_customer','u_customer.id','=','u_suggestion.customerId')
            ->select('u_suggestion.*','u_customer.name','u_customer.nickName')
            ->orderBy('createDate','desc')->paginate(5);
        return view('admin.suggestion.index',compact('data'));
    }
    //get admin/suggestion/create  添加意见反馈
    public function create(){
        // $data = (new Dictionary)->question();  //实例化类 并指向question方法
        return view('admin.suggestion.add');
    }
    //post admin/suggestion 添加意见反馈提交方法
    public function store(){
        $input = Input::except('_token');
        // dd($input);
        $input['customerId'] = '1';
        $input['createDate'] = time();//自动添加时候的时间
        //填写规则
        $rules = [
            'suggestionMember'=>'required',
        ];
        //填写提示信息
        $message = [
            'suggestionMember.required'=>'意见不能为空'
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = Suggestion::create($input);
            if($re){
                return redirect('admin/suggestion');
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }
    //get admin/suggestion/{suggestion}/edit   编辑意见反馈
    public function edit($id){
        // $data = (new Dictionary)->question();  //实例化类 并指向question方法
        $field = Suggestion::find($id);
        return view('admin.suggestion.edit',compact('field'));
    }
    //put admin/suggestion/{suggestion}   更新意见反馈
    public function update($id){
        $input = Input::except('_token','_method');
        // dd($input);
        $re = Suggestion::where('id',$id) ->update($input);
        if($re){
            return redirect('admin/suggestion');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
    //delete admin/suggestion/{suggestion}  删除单个意见反馈
    public function destroy($id){
        $re = Suggestion::where('id',$id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'意见反馈删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'意见反馈删除失败，请稍后重试S！'
            ];
        }
        return $data;
    }
    //get admin/suggestion/{suggestion}   显示单个意见反馈信息
    public function show(){

    }
}
