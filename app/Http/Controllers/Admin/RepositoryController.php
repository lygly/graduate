<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Dictionary;
use App\Http\Model\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class RepositoryController extends CommonController
{
    // get admin/repository   get方式过来的 后面是地址  全部问答列表
    public function index(){
        $data = Repository::join('sys_dictionary', 'sys_repository.typeId', '=', 'sys_dictionary.id')
            ->select('sys_repository.*', 'sys_dictionary.names')
            ->orderBy('createDate','desc')
            ->paginate(4);
        return view('admin.repository.index',compact('data'));
    }
    //get admin/repository/create  添加问答
    public function create(){
        $data = Dictionary::where('pId',3)->orderBy('sort','asc')->get();
       // dd($data);
       /* foreach ($data as $k=>$r) {
            //$this->logger($k.$r->names);
            // ($k+1).''.$r->names."</br>"
            echo "<p>" . ($k + 1) . ' ' . $r->names . "</p>";
        }*/
        return view('admin.repository.add',compact('data'));
    }
    //post admin/repository 添加问答提交方法
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
            $re = Repository::create($input);
            if($re){
                return redirect('admin/repository');
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }

        }else{
            return back()->withErrors($validator);
        }
    }
    //get admin/repository/{repository}/edit   编辑问答
    public function edit($id){
       // $data = (new Dictionary)->question();  //实例化类 并指向question方法
        $data = Dictionary::where('pId',3)->orderBy('sort','asc')->get();
        $field = Repository::find($id);
        return view('admin.repository.edit',compact('data','field'));
    }
    //put admin/repository/{repository}   更新问答
    public function update($id){
        $input = Input::except('_token','_method');
        $re = Repository::where('id',$id) ->update($input);
        if($re){
            return redirect('admin/repository');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }
    }
    //delete admin/repository/{repository}  删除单个问答
    public function destroy($id){
        $re = Repository::where('id',$id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'问答删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'问答删除失败，请稍后重试S！'
            ];
        }
        return $data;
    }
    //get admin/repository/{repository}   显示单个问答信息
    public function show(){

    }
}
