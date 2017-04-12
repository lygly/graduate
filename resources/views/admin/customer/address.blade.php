@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 基础配置 &raquo; 客户信息
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/customer')}}"><i class="fa fa-arrow-left"></i>返回</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">收货人姓名</th>
                        <th class="tc">电话</th>
                        <th class="tc">省</th>
                        <th class="tc">城市</th>
                        <th class="tc">区/县</th>
                        <th class="tc">详细地址</th>
                    </tr>
                    @foreach($data as $k=> $v)
                    <tr>
                        <td class="tc" width="5%">
                            <span type="text"  name="ord[]">{{$k+1}}</span>
                        </td>
                        <td class="tc">{{$v->acceptName}}</td>
                        <td class="tc">{{$v->tell}}</td>
                        <td class="tc">{{$v->province}}</td>
                        <td class="tc">{{$v->city}}</td>
                        <td class="tc">{{$v->district}}</td>
                        <td class="tc">{{$v->detailAddr}}</td>
                    </tr>
                    @endforeach
                </table>
                <div class="page_list">
                    {{$data->links()}}
                    <style>
                        .result_content ul li span {
                            padding: 6px 12px;
                        }
                    </style>
                </div>
            </div>
        </div>

@endsection