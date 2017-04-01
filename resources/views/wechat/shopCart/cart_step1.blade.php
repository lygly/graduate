@extends('layouts.wechat')
@section('content')
<body>
<div class="x-cart-actionbar weui-tabbar">
<div class="x-cart-actionbar-row2">
<span class="count">购物金额小计<strong>&yen;0</strong></span>
<span class="clean"><a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default">清空购物车</a></span>
</div>
<div class="x-cart-actionbar-row1">
<a href="{{url('/wechat')}}" class="weui-btn weui-btn weui-btn_default">继续购物</a>
<a href="javascript:;" class="weui-btn weui-btn_primary">下一步</a>
</div>
</div>

<div class="x-container">
<ol class="x-cart-stab">
<li class="active">1.购物车列表</li>
<li>2.确认订单</li>
<li>3.购买成功</li>
</ol>
    @if($data)
<ul class="x-cart-plist">
    @foreach($data as $d)
<li>
<div class="x-cart-plist-cover"><img id="plist-img" src="{{url('/'.$d->imgUrl)}}"/></div>
<div class="x-cart-plist-info" id="x-cart-plist-info">
<p class="title" id="title">{{$d->productName}}</p>
<p class="text" id="price">售价：<strong>{{$d->unitPrice}}</strong></p>
<p class="text" id="sum">小计：<strong>{{$d->unitPrice}}</strong></p>
    <p class="text">数量：
        <span class="num">
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default">-</a>
            <input type="text" size="1" value="{{$d->account}}" />
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default">+</a>
        </span>
    </p>
</div>
<a href="javascript:;" class="x-cart-plist-del"></a>
</li>
        @endforeach
</ul>
@else
        <div class="box" id="box">购物车里没有任何商品</div>
    @endif
</div>
</body>
@endsection
