@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 基础配置 &raquo; 客户信息
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>全部分类</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/customer/create')}}"><i class="fa fa-plus"></i>添加客户信息</a>
                    <a href="{{url('admin/customer')}}"><i class="fa fa-refresh"></i>刷新</a>
                    {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        {{--<th class="tc" width="5%"><input type="checkbox" name=""></th>--}}
                        <th class="tc">排序</th>
                        <th class="tc">姓名</th>
                        <th class="tc">电话</th>
                        <th class="tc">地址</th>
                        <th class="tc">身份证</th>
                        <th class="tc">省</th>
                        <th class="tc">城市</th>
                        <th class="tc">国家</th>
                        <th class="tc">昵称</th>
                        <th class="tc">性别</th>
                        <th class="tc">出生日期</th>
                        <th class="tc">体重(KG)</th>
                        <th class="tc">身高(cm)</th>
                        <th class="tc">积分</th>
                        <th class="tc">剩余积分</th>
                        <th class="tc">关注时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $k=> $v)
                    <tr>
                        {{--<td class="tc"><input type="checkbox" name="id[]" value="59"></td>--}}
                        <td class="tc" width="5%">
                            <span type="text"  name="ord[]">{{$k+1}}</span>
                        </td>
                        <td class="tc">{{$v->name}}</td>
                        <td class="tc">{{$v->phone}}</td>
                        <td class="tc">{{$v->addr}}</td>
                        <td class="tc">{{$v->useCode}}</td>
                        <td class="tc">{{$v->province}}</td>
                        <td class="tc">{{$v->city}}</td>
                        <td class="tc">{{$v->country}}</td>
                        <td class="tc">{{$v->nickName}}</td>
                        <td class="tc">
                            @if($v->sex==1)
                                男
                            @else
                                女
                                @endif
                        </td>
                        <td class="tc">{{$v->birthday}}</td>
                        <td class="tc">{{$v->weight}}</td>
                        <td class="tc">{{$v->height}}</td>
                        <td class="tc">{{$v->integrate}}</td>
                        <td class="tc">{{$v->usedIntegrate}}</td>
                        <td class="tc">{{date('Y-m-d',$v->subscribe_time)}}</td>
                        <td>
                            <a href="{{url('admin/customer/'.$v->id.'/edit')}}">修改</a>
                            <a href="javascript:;"onclick="delCate({{$v->id}})">删除</a>
                        </td>
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
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        //删除分类
        function delCate(cate_id) {
            layer.confirm('您确认要删除这个客户信息吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
             $.post('{{url('admin/customer/')}}'+'/'+cate_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
               if(data.status == 0){
                   layer.msg(data.msg, {icon: 6});
                   location.href = location.href;
               }else{
                   layer.msg(data.msg, {icon: 5});
               }
             });
            }, function(){

            });
        }

    </script>


@endsection