@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 基础配置 &raquo; 规格定义
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>全部信息</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/productSpec/create')}}"><i class="fa fa-plus"></i>添加</a>
                    <a href="{{url('admin/productSpec')}}"><i class="fa fa-refresh"></i>刷新</a>
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
                        <th class="tc">产品类别</th>
                        <th class="tc">规格</th>
                        <th class="tc">创建人</th>
                        <th class="tc">创建时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $k=> $v)
                    <tr>
                        {{--<td class="tc"><input type="checkbox" name="id[]" value="59"></td>--}}
                        <td class="tc" width="5%">
                            <span type="text"  name="ord[]">{{$k+1}}</span>
                        </td>
                        <td class="tc">{{$v->names}}</td>
                        <td class="tc">{{$v->spec}}</td>
                        <td class="tc">{{$v->createPerson}}</td>
                        <td class="tc">{{date('Y-m-d',$v->createDate)}}</td>
                        <td>
                            <a href="{{url('admin/productSpec/'.$v->id.'/edit')}}">修改</a>
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
             $.post('{{url('admin/productSpec/')}}'+'/'+cate_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
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