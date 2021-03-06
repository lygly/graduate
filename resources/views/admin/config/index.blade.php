@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo;网站配置管理
    </div>
    <!--面包屑导航 结束-->
    <!--搜索结果页面 列表 开始-->
        <div class="result_wrap">
            <div class="result_title">
                <h3>网站配置列表</h3>
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
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>添加配置</a>
                    <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置</a>
                    {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{url('admin/config/changeContent')}}" method="post">
                    {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>名称</th>
                        <th>内容</th>
                        {{--<th>类型值</th>
                        <th>说明</th>--}}
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc" width="5%">
                            <input type="text" onchange="changeOrder(this,'{{$v->conf_id}}')" name="ord[]" value="{{$v->conf_order}}">
                        </td>
                        <td class="tc" width="5%">{{$v->conf_id}}</td>
                        <td>
                            <a href="#">{{$v->conf_title}}</a>
                        </td>
                        <td>{{$v->conf_name}}</td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{$v->conf_id}}">
                            {!!$v->_html!!}
                        </td>
                        <td>
                            <a href="{{url('admin/config/'.$v->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:;"onclick="delLinks({{$v->conf_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                    <div class="btn_group">
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </div>
                </form>
            </div>
        </div>
    <!--搜索结果页面 列表 结束-->
    <script>
        //更改排序
        function changeOrder(obj,conf_id) {
            var conf_order = $(obj).val();
            $.post("{{url('admin/config/changeOrder')}}",{'_token':'{{csrf_token()}}','conf_id':conf_id,'conf_order':conf_order},function(data){
              if(data.status == 0){
                  layer.msg(data.msg, {icon: 6});
              }else{
                  layer.msg(data.msg, {icon: 5});
              }
            });
        }
        //删除自定义导航
        function delLinks(conf_id) {
            layer.confirm('您确认要删除这个分类吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
             $.post('{{url('admin/config/')}}'+'/'+conf_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
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