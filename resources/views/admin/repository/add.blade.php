@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>   &raquo; 基础配置 &raquo; 题库
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加分类</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))   {{--如果错误信息是新密码验证错误--}}
                    @foreach($errors->all() as $message)
                        <p> {{$message}}</p>
                    @endforeach
                    @else
                        <p>{{$errors}}</p>   {{--错误信息是一个字符串--}}
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/repository')}}"><i class="fa fa-reorder"></i>全部问答</a>
                <a href="{{url('admin/repository/create')}}"><i class="fa fa-recycle"></i>刷新</a>
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/repository')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>类别：</th>
                        <td>
                            <select name="typeId">
                                {{--列出父级分类--}}
                                <option value="{{$d->id}}">{{$d->_names}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>问题：</th>
                        <td>
                            <input  class="lg" type="text" name="question">
                            <input type="text" name="createPerson" value="admin" hidden>
                            <span><i class="fa fa-exclamation-circle yellow"></i>问题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>答案：</th>
                        <td>
                            <textarea  type="text" name="answer"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
       $(function(){
         var submit = $(":submit");//提交按钮
         submit.click(function(){
             //为leavels赋值
             var dataPId = $('select option:selected').val();
             var Leavels =$('#leavels');
             if(dataPId==0){
                 Leavels.val(1);
             }else{
                 Leavels.val(2);
             }
         });
       });
    </script>
@endsection