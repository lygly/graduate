@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>   &raquo; 基础配置 &raquo; 客户信息
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加客户信息</h3>
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
                <a href="{{url('admin/customer')}}"><i class="fa fa-reorder"></i>全部客户信息</a>
                <a href="{{url('admin/customer/create')}}"><i class="fa fa-recycle"></i>刷新</a>
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/customer')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>姓名：</th>
                        <td>
                            <input type="text" name="name" placeholder="姓名">
                            <span><i class="fa fa-exclamation-circle yellow"></i>姓名必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>电话：</th>
                        <td>
                            <input  type="text" name="phone" placeholder="电话">
                        </td>
                    </tr>
                    <tr>
                        <th>地址：</th>
                        <td>
                            <input  type="text" name="addr" placeholder="地址">
                        </td>
                    </tr>
                    <tr>
                        <th>身份证：</th>
                        <td>
                            <input  type="text" name="useCode" placeholder="身份证">
                        </td>
                    </tr>
                    <tr>
                        <th>省：</th>
                        <td>
                            <input  type="text" name="province" placeholder="省">
                        </td>
                    </tr>
                    <tr>
                        <th>城市：</th>
                        <td>
                            <input  type="text" name="city" placeholder="城市">
                        </td>
                    </tr>
                    <tr>
                        <th>国家：</th>
                        <td>
                            <input  type="text" name="country" placeholder="国家">
                        </td>
                    </tr>
                    <tr>
                        <th>性别：</th>
                        <td>
                            <select name="gender" id="">
                                <option value="1">男</option>
                                <option value="2">女</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>出生日期：</th>
                        <td>
                            <div>
                            <input  type="text" id="birthday" name="birthday" style="width:170px;padding:7px 10px;border:1px solid #ccc;margin-right:10px;" placeholder="出生日期"></div>
                        </td>
                    </tr>
                    <tr>
                        <th>体重：</th>
                        <td>
                            <input  type="text" name="weight" placeholder="体重">
                            <span><i class="fa fa-exclamation-circle yellow"></i>单位KG</span>
                        </td>
                    </tr>
                    <tr>
                        <th>身高：</th>
                        <td>
                            <input  type="text" name="height" placeholder="身高">
                            <span><i class="fa fa-exclamation-circle yellow"></i>单位cm</span>
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
        $(function () {
            $(".add_tab input").attr('class','lg');//给输入框添加样式
            $("#birthday").calendar();
        })
    </script>
@endsection