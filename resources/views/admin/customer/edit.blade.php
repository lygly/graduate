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
                <a href="{{url('admin/customer/create')}}"><i class="fa fa-plus"></i>添加客户信息</a>
                <a href="{{url('admin/customer')}}"><i class="fa fa-reorder"></i>全部客户信息</a>
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/customer/'.$field->id)}}" method="post">
            <input type="hidden" name="_method" value="put">  {{--put 方式提交表单--}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>姓名：</th>
                    <td>
                        <input type="text" name="name" placeholder="姓名" value="{{$field->name}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>姓名必须填写</span>
                    </td>
                </tr>
                <tr>
                    <th>电话：</th>
                    <td>
                        <input  type="text" name="phone" placeholder="电话" value="{{$field->phone}}">
                    </td>
                </tr>
                <tr>
                    <th>地址：</th>
                    <td>
                        <input  type="text" name="addr" placeholder="地址" value="{{$field->addr}}">
                    </td>
                </tr>
                <tr>
                    <th>身份证：</th>
                    <td>
                        <input  type="text" name="useCode" placeholder="身份证" value="{{$field->useCode}}">
                    </td>
                </tr>
                <tr>
                    <th>省：</th>
                    <td>
                        <input  type="text" name="province" placeholder="省" value="{{$field->province}}">
                    </td>
                </tr>
                <tr>
                    <th>城市：</th>
                    <td>
                        <input  type="text" name="city" placeholder="城市" value="{{$field->city}}">
                    </td>
                </tr>
                <tr>
                    <th>国家：</th>
                    <td>
                        <input  type="text" name="country" placeholder="国家" value="{{$field->country}}">
                    </td>
                </tr>
                <tr>
                    <th>性别：</th>
                    <td>
                        <select name="sex" id="">
                            <option value="1" @if($field->sex==1) selected @endif>男</option>
                            <option value="2" @if($field->sex==2) selected @endif>女</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>出生日期：</th>
                    <td>
                        <input  type="text" class="wicon mr25 "  name="birthday" style="width: 200px" id="birthday" placeholder="出生日期" readonly value="{{$field->birthday}}">
                    </td>
                </tr>
                <tr>
                    <th>体重：</th>
                    <td>
                        <input  type="text" name="weight" placeholder="体重" value="{{$field->weight}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>单位KG</span>
                    </td>
                </tr>
                <tr>
                    <th>身高：</th>
                    <td>
                        <input  type="text" name="height" placeholder="身高" value="{{$field->height}}">
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
    <style>
        .mr25{margin-right:25px;}
        .wicon{background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAQCAYAAADj5tSrAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAwNi8xNS8xNGnF/oAAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAAAoElEQVQ4jWPceOnNfwYqAz9dYRQ+E7UtwAaGjyUsDAyYYUgJ2HT5LXZLcEmSCnA6duOlN///////H0bDALl8dPH/////Z8FuNW6Qtvw2nL3lyjsGBgYGhlmRqnj1kGwJuqHIlhJlCXq8EOITEsdqCXLEbbr8FisfFkTo+vBZRFZwERNEFFkCiw90nxJtCalxQmzegltCzVyP1RJq5HZ8AABuNZr0628DMwAAAABJRU5ErkJggg=="); background-repeat:no-repeat; background-position:right center;}
    </style>
    <script>
        jeDate({
            dateCell:"#birthday",//isinitVal:true,
            format:"YYYY-MM-DD",
            isTime:false, //isClear:false,
            isinitVal:true//是否初始化日期
            // minDate:"2015-10-19 00:00:00",
            //maxDate:$.nowDate(0)
        });
        $(function () {
            $(".add_tab input").not(".back").not(":submit").addClass('lg');
        })
        </script>
@endsection