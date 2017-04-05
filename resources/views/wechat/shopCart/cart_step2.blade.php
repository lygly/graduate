@extends('layouts.wechat')
@section('content')
<body>
<div class="x-cart-actionbar">
<div class="x-cart-actionbar-row1">
<a href="javascript:;" class="weui-btn weui-btn weui-btn_default">上一步</a>
<a href="javascript:;" class="weui-btn weui-btn_primary">结算中心</a>
</div>
</div>

<div class="x-container">
<ol class="x-cart-stab">
<li>1.购物车列表</li>
<li class="active">2.确认订单</li>
<li>3.购买成功</li>
</ol>

<div class="x-cart-addr">
<textarea placeholder="请输入收货地址"></textarea>
</div>
</div>

</body>
@endsection
