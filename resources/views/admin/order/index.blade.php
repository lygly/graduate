@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a>  &raquo; 基础配置 &raquo; 订单管理
    </div>
    <!--面包屑导航 结束-->
        <div class="result_wrap">
            <div  class="result_content"style="float: left;width: 75%;">


            <div style=" overflow-x: scroll;">
                <div class="result_title">
                    <h3>客户订单</h3>
                </div>
                <table class="list_tab" style="min-width:1000px;">
                    <tr>
                        <th class="tc">排序</th>
                        <th>操作</th>
                        <th class="tc">订单编号</th>
                        <th>客户名称</th>
                        <th>订单日期</th>
                        <th>收货地址</th>
                        <th>收货人</th>
                        <th>收货人电话</th>
                        <th>订单状态</th>
                        <th>总金额</th>
                        <th>付款金额</th>
                        <th>付款状态</th>
                        <th>备注</th>

                    </tr>
                    @foreach($data as $k=> $v)
                    <tr onclick="detail({{$v->orderCode}})" >
                        <td class="tc" width="5%">
                            <span type="text" name="ord[]">{{$k+1}}</span>
                        </td>
                        <td class="tc" width="5%"> <a href="javascript:;"onclick="delCate({{$v->orderCode}})">删除</a></td>
                        <td class="tc" width="5%">{{$v->orderCode}}</td>
                        <td>{{$v->name}}</td>
                        <td>{{date('Y-m-d',$v->orderDate)}}</td>
                        <td>{{$v->province.$v->city.$v->district.$v->detailAddr}}</td>
                        <td>{{$v->acceptName}}</td>
                        <td>{{$v->tell}}</td>
                        <td>@if($v->statuse==01) 编制 @endif</td>
                        <td>{{$v->sumMoney}}</td>
                        <td>{{$v->payment}}</td>
                        <td>待付款</td>
                        <td>{{$v->mark}}</td>
                    </tr>
                    @endforeach
                </table>
                </div>
            <div class="page_list">
                {{$data->links()}}
                <style>
                    .result_content ul li span {
                        padding: 6px 12px;
                    }
                </style>
            </div>
            </div>
            <div class="result_content" style="width:23%; float: right; overflow-x:scroll">
                <div class="result_title">
                    <h3>订单明细</h3>
                </div>
                <table class="list_tab" style="min-width: 300px;" id="detail">
                    <tr>
                        <th>排序</th>
                        <th>订单编号</th>
                        <th>名称</th>
                     {{--   <th>规格</th>
                        <th>颜色</th>--}}
                        <th>价格</th>
                        <th>数量</th>
                    </tr>
                   {{--@include('admin.order.orderDetail')--}}
                </table>
            </div>
        </div>
    <!--搜索结果页面 列表 结束-->
    <script>
      function detail(orderCode) {
          $.post("{{url('admin/order/detail')}}",{'_token':'{{csrf_token()}}','orderCode':orderCode},function (data) {
              console.log(data);
              $("#detail").empty().append(data);
          })
      }


        //删除分类
        function delCate(cate_id) {
            layer.confirm('您确认要删除这个订单吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
             $.post('{{url('admin/order/')}}'+'/'+cate_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
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