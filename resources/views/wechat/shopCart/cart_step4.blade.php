@extends('layouts.wechat')
@section('content')

<body>
<div class="x-cart-actionbar">
<div class="x-cart-actionbar-row3">
<a href="javascript:;" class="weui-btn weui-btn_primary">返回</a>
</div>
</div>

<div class="x-container">
<div class="x-cart-paystatus">
<i class="x-icon-paystatus1 x-icon-paystatus1-1"></i>
<p class="title"><i class="x-icon-paystatus2 x-icon-paystatus2-1"></i>成功支付</p>
<p class="text">订单号：12345678901234567890</p>
</div>

<div class="x-cart-paystatus">
<i class="x-icon-paystatus1 x-icon-paystatus1-2"></i>
<p class="title"><i class="x-icon-paystatus2 x-icon-paystatus2-2"></i>支付错误</p>
<p class="text">支付网络延迟</p>
</div>
</div>

</body>
@endsection
