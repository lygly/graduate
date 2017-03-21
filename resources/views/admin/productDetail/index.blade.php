@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 商品管理 &raquo; 商品清单
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
                    <a href="{{url('admin/productDetail/create')}}"><i class="fa fa-plus"></i>添加</a>
                    <a href=""><i class="fa fa-refresh"></i>刷新</a>
                    <a href="{{url('admin/product')}}"><i class="fa fa-arrow-left"></i>返回</a>
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
                        <th class="tc">批次号</th>
                        <th class="tc">颜色</th>
                        <th class="tc">规格</th>
                        <th class="tc">产品单价</th>
                        <th class="tc">数量</th>
                        <th class="tc">状态</th>
                        <th class="tc">生产日期</th>
                        <th class="tc">有效期</th>
                        <th class="tc">到期日期</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $k=> $v)
                    <tr>
                        {{--<td class="tc"><input type="checkbox" name="id[]" value="59"></td>--}}
                        <td class="tc" width="5%">
                            <span type="text"  name="ord[]">{{$k+1}}</span>
                        </td>
                        <td class="tc">{{$v->batchNo}}</td>
                        <td class="tc">{{$v->names}}</td>
                        <td class="tc">{{$v->spec}}</td>
                        <td class="tc">{{$v->unitPrice}}</td>
                        <td class="tc">{{$v->account}}</td>
                        <td class="tc">
                            @if($v->status=='01')
                             正常
                            @elseif($v->status=='04')
                              已下架
                            @else
                              已报废
                            @endif
                        </td>
                        <td class="tc">{{date('Y-m-d',$v->startDate)}}</td>
                        <td class="tc">{{($v->Validity) }}</td>
                        <td class="tc">{{date('Y-m-d',$v->endDate)}}</td>
                        <td>
                            <a href="{{url('admin/productDetail/'.$v->id.'/edit')}}">修改</a>
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
            layer.confirm('您确认要删除这个商品清单信息吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
             $.post('{{url('admin/productDetail/')}}'+'/'+cate_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
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