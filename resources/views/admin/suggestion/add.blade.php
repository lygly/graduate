@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>   &raquo; 基础配置 &raquo;  意见反馈
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加</h3>
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
                <a href="{{url('admin/suggestion')}}"><i class="fa fa-reorder"></i>全部</a>
                <a href="{{url('admin/suggestion/create')}}"><i class="fa fa-recycle"></i>刷新</a>
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/suggestion')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    {{--<tr>
                        <th><i class="require">*</i>客户姓名：</th>
                        <td>
                            <input type="text" name="project" placeholder="主题" hidden>
                            <span><i class="fa fa-exclamation-circle yellow"></i>主题必须填写</span>
                        </td>
                    </tr>--}}
                    <tr>
                        <th>内容：</th>
                        <td>
                            {{--文本框插件--}}
                            <script type="text/javascript" charset="utf-8" src="{{asset('app/org/ueditor/ueditor.config.js')}}"></script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('app/org/ueditor/ueditor.all.min.js')}}"> </script>
                            <script type="text/javascript" charset="utf-8" src="{{asset('app/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                            <script id="editor" name="suggestionMember" type="text/plain" style="width:860px;height:500px;"></script>
                            <script> var ue = UE.getEditor('editor')</script>
                            <style>
                                .edui-default{line-height: 28px;}
                                div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                                {overflow: hidden; height:20px;}
                                div.edui-box{overflow: hidden; height:22px;}
                            </style>
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
           /* jeDate({
                dateCell:"#birthday",//isinitVal:true,
                format:"YYYY-MM-DD",
                isTime:false, //isClear:false,
               // isinitVal:true//是否初始化日期
               // minDate:"2015-10-19 00:00:00",
                //maxDate:$.nowDate(0)
            });*/
        })
    </script>
@endsection