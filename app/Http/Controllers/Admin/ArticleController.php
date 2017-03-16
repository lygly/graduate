<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    // get admin/article   get方式过来的 后面是地址  全部文章列表
    public function index(){
        $data = Article::orderBy('art_id','desc')->paginate(5); //读取数据按ID倒叙显示并且每一页显示5条记录
        return view('admin.article.index',compact('data'));
    }
    //get admin/article/create  添加文章
    public function create(){
        $data = (new Category)->tree(); //读取分类栏目
       return view('admin.article.add',compact('data'));
    }
    //post admin/article 添加文章提交方法
    public function store(){
      $input = Input::except('_token','PHPSESSID');
      $input['art_time'] = time();//自动添加文章添加时候的时间
        //填写规则
        $rules = [
            'art_title'=>'required',   //art_title 字段必填
            'art_content'=>'required',
        ];
        //填写提示信息
        $message = [
            'art_title.required'=>'文章标题不能为空',
            'art_content.required'=>'文章内容不能为空',
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = Article::create($input);
            if ($re){
                return redirect('admin/article');  //返回到文章列表页面
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);  //返回错误信息
        }
    }
    //get admin/article/{article}/edit   修改文章
    public function edit($art_id){
        $data = (new Category)->tree(); //读取分类栏目
        //$data = Category::where('cate_pid',0)->get();
        $field =  Article::find($art_id);
        return view('admin.article.edit',compact('field','data'));

    }
    //put admin/article/{article}   更新文章
    public function update($art_id){
        $input = Input::except('_token','_method');//接收网页更改的数据
        $re = Article::where('art_id',$art_id) ->update($input);
        if($re){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章更新失败，请稍后重试！');
        }

    }
    //delete admin/article/{article}  删除单个分类
    public function destroy($art_id){
        $re = Article::where('art_id',$art_id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'文章删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'文章删除失败，请稍后重试S！'
            ];
        }
        return $data;

    }
    //get admin/category/{category}   显示单个分类信息
    public function show(){

    }
}
