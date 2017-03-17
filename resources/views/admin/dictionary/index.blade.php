@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 基础配置 &raquo; 类型管理
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
                    <a href="{{url('admin/dictionary/create')}}"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="{{url('admin/dictionary')}}"><i class="fa fa-recycle"></i>刷新</a>
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
                        <th class="tc">ID</th>
                       {{-- <th>分类</th>--}}
                        <th>分类名称</th>
                        <th>等级</th>
                        <th>是否系统配置</th>
                        {{--<th>更新时间</th>
                        <th>评论</th>--}}
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        {{--<td class="tc"><input type="checkbox" name="id[]" value="59"></td>--}}
                        <td class="tc" width="5%">
                            <input type="text" onchange="changeOrder(this,'{{$v->id}}')" name="ord[]" value="{{$v->sort}}">
                        </td>
                        <td class="tc" width="5%">{{$v->id}}</td>
                        <td>
                            <a href="#">{{$v->_names}}</a>
                        </td>
                        @if($v->leavels==1)
                        <td>一级菜单</td>
                        @elseif($v->leavels==2)
                        <td>二级菜单</td>
                        @else
                            <td></td>
                        @endif
                        @if($v->isBasic==1)
                        <td>是</td>
                        @elseif($v->isBasic==0)
                        <td>否</td>
                        @endif
                        {{--<td>admin</td>
                        <td>2014-03-15 21:11:01</td>
                        <td></td>--}}
                        <td>
                            <a href="{{url('admin/dictionary/'.$v->id.'/edit')}}">修改</a>
                            @if($v->isDel==1)
                            <a href="javascript:;"onclick="delCate({{$v->id}})">删除</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        //更改排序
        function changeOrder(obj,cate_id) {
            var cate_order = $(obj).val();
            $.post("{{url('admin/dictionary/changeOrder')}}",{'_token':'{{csrf_token()}}','id':cate_id,'sort':cate_order},function(data){
              if(data.status == 0){
                  layer.msg(data.msg, {icon: 6});
              }else{
                  layer.msg(data.msg, {icon: 5});
              }
            });
        }
        //删除分类
        function delCate(cate_id) {
            layer.confirm('您确认要删除这个分类吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
             $.post('{{url('admin/dictionary/')}}'+'/'+cate_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
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