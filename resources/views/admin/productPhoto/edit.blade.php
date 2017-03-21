@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>   &raquo;  商品管理 &raquo; 商品清单
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
                <a href="{{url('admin/productDetail/create')}}"><i class="fa fa-plus"></i>添加</a>
                <a href=""><i class="fa fa-refresh"></i>刷新</a>
                <a href="{{url('admin/productDetail/'.session('productId'))}}"><i class="fa fa-arrow-left"></i>返回</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/productDetail/'.$field->id)}}" method="post">
            <input type="hidden" name="_method" value="put">  {{--put 方式提交表单--}}
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>批次号</th>
                    <td>
                        <input type="text" name="batchNo" placeholder="批次号" value="{{$field->batchNo}}">
                        <span><i class="fa fa-exclamation-circle yellow"></i>批次号必须填写</span>
                    </td>
                </tr>
                <tr>
                    <th width="120"><i class="require">*</i>产品属性：</th>
                    <td>
                        <select name="propertyId">
                            <option value="">==选择规格属性==</option>
                            @foreach($data as $d)
                                <option value="{{$d->id}}"
                                @if($d->id == $field->propertyId)
                                    selected
                                @endif
                                >{{$d->spec.'--'.$d->names.'--'.$d->unitPrice}}</option>
                            @endforeach
                        </select>
                        <span><i class="fa fa-exclamation-circle yellow"></i>依次为：规格--颜色--单价</span>
                    </td>
                </tr>
                <tr>
                    <th width="120">数量：</th>
                    <td>
                        <input type="text" name="account" placeholder="数量" value="{{$field->account}}">
                    </td>
                </tr>
                <tr>
                    <th width="120">状态：</th>
                    <td>
                        <select name="status" id="">
                            <option value="01"@if($field->status=='01') selected @endif>正常</option>
                            <option value="04" @if($field->status=='04') selected @endif>已下架</option>
                            <option value="06" @if($field->status=='06') selected @endif>已报废</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>生产日期：</th>
                    <td>
                        <input type="text" name="startDate" id="startDate" placeholder="生产日期" class="mr25 wicon"value="{{date('Y-m-d',$field->startDate)}}" >
                        <input type="hidden" name="productId" value="{{session('productId')}}">
                    </td>
                </tr>
                <tr>
                    <th>有效期（月）：</th>
                    <td>
                        <input type="text" name="Validity"  placeholder="有效期"value="{{$field->Validity}}" >
                    </td>
                </tr>
                <tr>
                    <th>到期日期：</th>
                    <td>
                        <input type="text" name="endDate" id="endDate" placeholder="到期日期" class="mr25 wicon" value="{{date('Y-m-d',$field->endDate)}}" >
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