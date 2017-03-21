@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>   &raquo;  商品管理 &raquo; 商品属性
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>修改</h3>
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
                <a href="{{url('admin/productProperty/create')}}"><i class="fa fa-plus"></i>添加</a>
                <a href=""><i class="fa fa-refresh"></i>刷新</a>
                <a href="{{url('admin/productProperty')}}"><i class="fa fa-arrow-left"></i>返回</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/productProperty/'.$field->id)}}" method="post">
            <input type="hidden" name="_method" value="put">  {{--put 方式提交表单--}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>规格：</th>
                    <td>
                        <select name="specId">
                            <option value="">==选择规格==</option>
                            @foreach($data as $d)
                                <option value="{{$d->id}}"
                                @if($d->id==$field->specId)
                                    selected
                                @endif
                                >{{$d->spec}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th width="120">颜色：</th>
                    <td>
                        <select name="colorId">
                            <option value="">==选择颜色==</option>
                            @foreach($color as $c)
                                <option value="{{$c->id}}"
                                @if($c->id==$field->colorId)
                                   selected
                                @endif
                                >{{$c->names}}</option>
                            @endforeach
                        </select>
                        <span><i class="fa fa-exclamation-circle yellow"></i>不是必填</span>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>产品单价：</th>
                    <td>
                        <input type="text" name="unitPrice" placeholder="产品单价" onkeyup="num(this);" value="{{$field->unitPrice}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>单价必须填写数字，可以保留两位小数</span>
                    </td>
                </tr>
                <tr>
                    <th>上架：</th>
                    <td>
                        <input type="checkbox" name="isMarket" id="isMarket" onchange="javascript:change(this);" @if($field->isMarket=='on')
                            checked @endif>
                    </td>
                </tr>
                <tr>
                    <th>上架时间：</th>
                    <td>
                        <input type="text" name="marketDate" id="marketDate" placeholder="上架时间" class="mr25 wicon" value="{{date('Y-m-d',$field->marketDate)}}" >
                    </td>
                </tr>
                <tr>
                    <th>下架时间：</th>
                    <td>
                        <input type="text" name="outMarketDate" id="outMarketDate" placeholder="下架时间" class="mr25 wicon"
                               @if($field->outMarketDate)
                               value="{{date('Y-m-d',$field->outMarketDate)}}"
                               @endif
                        >
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
        .mr25{margin-right:25px; width: 268px;}
        .wicon{background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAQCAYAAADj5tSrAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAwNi8xNS8xNGnF/oAAAAAcdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3JrcyBDUzVxteM2AAAAoElEQVQ4jWPceOnNfwYqAz9dYRQ+E7UtwAaGjyUsDAyYYUgJ2HT5LXZLcEmSCnA6duOlN///////H0bDALl8dPH/////Z8FuNW6Qtvw2nL3lyjsGBgYGhlmRqnj1kGwJuqHIlhJlCXq8EOITEsdqCXLEbbr8FisfFkTo+vBZRFZwERNEFFkCiw90nxJtCalxQmzegltCzVyP1RJq5HZ8AABuNZr0628DMwAAAABJRU5ErkJggg=="); background-repeat:no-repeat; background-position:right center;}
    </style>
    <script>
        jeDate({
            dateCell:"#marketDate",//isinitVal:true,
            format:"YYYY-MM-DD",
            isTime:false, //isClear:false,
            //isinitVal:true//是否初始化日期
        });
        jeDate({
            dateCell:"#outMarketDate",//isinitVal:true,
            format:"YYYY-MM-DD",
            isTime:false, //isClear:false,
        });
        $(function () {
          //  $(".add_tab input").not(".back").not(":submit").addClass('lg');
        })
        </script>
@endsection