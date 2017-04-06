@extends('layouts.wechat')
@section('content')
    <style>
        .weui-panel__hd:after{
            position: relative;
        }
    </style>
<body>
<form action="">
<div class="x-cart-actionbar">
<div class="x-cart-actionbar-row1">
<a href="{{url('wechat/shopCart')}}" class="weui-btn weui-btn weui-btn_default">上一步</a>
<a href="javascript:;" class="weui-btn weui-btn_primary">结算中心</a>
</div>
</div>

<div class="x-container">
<ol class="x-cart-stab">
<li>1.购物车列表</li>
<li class="active">2.确认订单</li>
<li>3.购买成功</li>
</ol>

{{--<div class="x-cart-addr">
<textarea placeholder="请输入收货地址"></textarea>
</div>--}}
    <div class="weui-cells__title">收货地址</div>
    <div class="weui-panel weui-panel_access">
       <div class="weui-panel__hd weui-flex" style="display: block; overflow: hidden; cursor: pointer;" id="addr">
          <div class="weui-media-box_text weui-flex__item" style="width: 85%; float: left;">
              <p style="line-height: 25px;">{{$data->province.$data->city.$data->district.$data->detailAddr}}</p>
              <p style="line-height: 25px;"><span>{{$data->acceptName}}</span> <span>{{$data->tell}}</span></p>
              <input type="hidden" id="customerId" value="{{$data->customerId}}">
          </div>
           <div style="float: right;">
               <a class="placeholder"href="{{url('wechat/shopAddr/'.$data->id.'/edit')}}">修改</a>
           </div>
       </div>
    </div>
</div>
</form>
<script>
    $(function () {
        $("#addr").click(function () {
            var customerId = $("#customerId").val();

            location.href="http://www.lylyg2017.cn/graduate/wechat/shopCart/"+customerId+"/edit";
        })
    })
</script>
</body>
@endsection
