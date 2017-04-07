@extends('layouts.wechat')
@section('content')
    <style>
        .weui-panel__hd:after{
            position: relative;
        }
    </style>
<body>
<form action="{{url('wechat/shopCart/order')}}" method="post">
<div class="x-cart-actionbar" style="z-index: 1;">
    <div class="x-cart-actionbar-row2">
        <span class="count">总金额<strong>&yen;<span id="count">{{session('sumMoney')}}</span>
             <input type="hidden" name="sumMoney" value="{{session('sumMoney')}}">   {{-- 总金额--}}
             <input type="hidden" name="payment" value="{{session('sumMoney')}}">  {{--付款金额--}}
            </strong></span>
    </div>
<div class="x-cart-actionbar-row1">
<a href="{{url('wechat/shopCart')}}" class="weui-btn weui-btn weui-btn_default">上一步</a>
<a href="javascript:;" class="weui-btn weui-btn_primary" id="submit">结算中心</a>
    {{--<input type="submit" class="weui-btn weui-ben_primary" value="结算中心">--}}
</div>
</div>

<div class="x-container">
<ol class="x-cart-stab">
<li>1.购物车列表</li>
<li class="active">2.确认订单</li>
<li>3.购买成功</li>
</ol>
    <div class="weui-cells__title">收货地址</div>
    <div class="weui-panel weui-panel_access">
       <a class="weui-panel__hd weui-flex" href="{{url('wechat/shopCart/'.$data->customerId.'/edit')}}">
          <div class="weui-media-box_text weui-flex__item" style="width: 85%; float: left;">
              <p style="line-height: 25px;">{{$data->province.$data->city.$data->district.$data->detailAddr}}</p>
              <p style="line-height: 25px;"><span>{{$data->acceptName}}</span> <span>{{$data->tell}}</span></p>
              <input type="hidden" id="customerId" name="customerId" value="{{$data->customerId}}">
              <input type="hidden" name="addressId" value="{{$data->id}}">
          </div>
       </a>
    </div>
    {{--商品列表--}}
    <div class="weui-cells__title">  </div>
    <ul class="x-cart-plist">
        @foreach($goods as $k=>$v)
          <li id="{{$v->productId}}">
              <input type="hidden" name="productId[]" value="{{$v->productId}}">
    <div class="x-cart-plist-cover">
        <img id="plist-img" style="width: 60%;" src="{{url('/'.$v->imgUrl)}}"/>
    </div>
    <div class="x-cart-plist-info" id="x-cart-plist-info">
        <p class="title" id="title">{{$v->productName}}</p>
        <p class="text">售价：<strong id="price">{{$v->unitPrice}}</strong></p>
        <p class="text">小计：
            <strong id="sum">{{$v->unitPrice}}</strong>
            <input type="hidden" name="uintPrice[]" value="{{$v->unitPrice}}">
        </p>
        <p class="text">数量：
            <span class="num">
            <input type="text" size="1" value="{{$v->account}}" name="account[]" id="account"/>
        </span>
        </p>
    </div>
</li>
    @endforeach
</ul>
</div>
</form>
<script>
    $(function () {
        $("#submit").click(function () {
            $("form").submit();
        })
    })
</script>
</body>
@endsection
