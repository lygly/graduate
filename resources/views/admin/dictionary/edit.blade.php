@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>   &raquo; 基础配置 &raquo; 类型管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>修改分类</h3>
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
                <a href="{{url('admin/dictionary/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{url('admin/dictionary')}}"><i class="fa fa-reorder"></i>全部分类</a>
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/dictionary/'.$field->id)}}" method="post">
            <input type="hidden" name="_method" value="put">  {{--put 方式提交表单--}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="pId">
                                <option value="0">==顶级分类==</option>
                                {{--列出父级分类--}}
                                @foreach($data as $d)
                                <option value="{{$d->id}}"
                                @if($d->id == $field->pId )
                                    selected
                                    @endif
                                >{{$d->names}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="names" value="{{$field->names}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>名称必须填写</span>
                        </td>
                    </tr>
                    <tr style="display: none;">
                        <th><i class="require">*</i>级别：</th>
                        <td>
                            <input id="leavels" type="text" name="leavels" value="{{$field->leavels}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>是否可删除：</th>
                        <td>
                            <select name="isDel" id="">
                                @if($field->isDel==1)
                                <option value="{{$field->isDel}}" selected>可以删除</option>
                                <option value="0">不能删除</option>
                                @elseif($field->isDel==0&&$field->pId==0)
                                <option value="{{$field->isDel}}" selected>不能删除</option>
                                @elseif($field->isDel==0)
                                    <option value="{{$field->isDel}}" selected>不能删除</option>
                                    <option value="1">可以删除</option>
                                @endif
                            </select>
                            <span><i class="fa fa-exclamation-circle yellow"></i>必须填写</span>
                        </td>
                    </tr>


                    <tr>
                        <th><i class="require">*</i>是否系统配置：</th>
                        <td>
                            <select name="isBasic" id="">
                                @if($field->isBasic==0)
                                <option value="{{$field->isBasic}}" selected>不是系统配置</option>
                                <option value="1">是系统配置</option>
                                    @else
                                    <option value="{{$field->isBasic}}" selected>是系统配置</option>
                                    <option value="0">不是系统配置</option>
                                @endif
                            </select>
                            <span><i class="fa fa-exclamation-circle yellow"></i>必须填写</span>
                        </td>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="sort" value="{{$field->sort}}">
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

@endsection