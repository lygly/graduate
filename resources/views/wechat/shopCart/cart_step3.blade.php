@extends('layouts.wechat')
@section('content')
    <style>
        #prev{
            border:#4b7cea 1px solid;

        }
    </style>
<body><form action="{{url('wechat/shopCart/addr/'.session('customer_id'))}}">
<div class="x-cart-actionbar">
<div class="x-cart-actionbar-row1">
    <input type="submit" class="weui-btn weui-btn_default" value="上一步" id="prev">
    <input type="hidden" name="addrId" value="{{session('addrId')}}">
<a href="{{url('wechat/shopCart/pay')}}" class="weui-btn weui-btn_primary">去支付</a>
</div>
</div></form>

<div class="x-container">
<ol class="x-cart-stab">
<li>1.购物车列表</li>
<li>2.确认订单</li>
<li class="active">3.购买成功</li>
</ol>

<div class="weui-cells weui-cells_radio x-cart-paytype">
<label class="weui-cell weui-check__label" for="x11">
<div class="weui-cell__hd"><i class="x-icon-paytype x-icon-paytype-1"></i></div>
<div class="weui-cell__bd">
<p>微信支付</p>
</div>
<div class="weui-cell__ft">
<input type="radio" class="weui-check" name="radio1" id="x11" checked="checked" />
<span class="weui-icon-checked"></span>
</div>
</label>
<label class="weui-cell weui-check__label" for="x12">
<div class="weui-cell__hd"><i class="x-icon-paytype x-icon-paytype-2"></i></div>
<div class="weui-cell__bd">
<p>支付宝支付</p>
</div>
<div class="weui-cell__ft">
<input type="radio" name="radio1" class="weui-check" id="x12" />
<span class="weui-icon-checked"></span>
</div>
</label>
<label class="weui-cell weui-check__label" for="x13">
<div class="weui-cell__hd"><i class="x-icon-paytype x-icon-paytype-3"></i></div>
<div class="weui-cell__bd">
<p>银行卡</p>
</div>
<div class="weui-cell__ft">
<input type="radio" name="radio1" class="weui-check" id="x13" />
<span class="weui-icon-checked"></span>
</div>
</label>
</div>
</div>
</body>
@endsection
