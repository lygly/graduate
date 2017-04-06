@extends('layouts.wechat')
@section('content')
<body>
<form action="{{url('wechat/shopCart/'.session('customer_id').'/edit')}}" method="post">
    <input type="hidden" name="_method" value="get">

<div class="x-cart-actionbar" style="z-index: 1;">
<div class="x-cart-actionbar-row2">
<span class="count">购物金额小计<strong>&yen;<span id="count"></span></strong></span>
<span class="clean"><a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default" onclick="delAll()">清空购物车</a></span>
</div>
    <div class="x-cart-actionbar-row1">
        <a href="{{url('/wechat')}}" class="weui-btn weui-btn weui-btn_default">继续购物</a>
        {{--<a href="javascript:;" class="weui-btn weui-btn_primary">下一步</a>--}}
        <input type="submit" class="weui-btn weui-btn_primary" value="下一步" >
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
<li id="{{$d->productId}}" style="padding: 0;">
    <div class=" weui-cells_checkbox">
        <label class="weui-cell weui-check__label" for="p{{$d->productId}}">
            <div class="weui-cell__hd">
                <input type="checkbox" class="weui-check" name="productId{{$d->productId}}" id="p{{$d->productId}}" value="{{$d->productId}}" checked="checked">
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <div class="x-cart-plist-cover" style="width: 30%;">
                    <img id="plist-img" style="" src="{{url('/'.$d->imgUrl)}}"/>
                </div>
                <div class="x-cart-plist-info" id="x-cart-plist-info" style="margin-left: 32%;">
                    <p class="title" id="title">{{$d->productName}}</p>
                    <p class="text">售价：<strong id="price">{{$d->unitPrice}}</strong></p>
                    <p class="text">小计：<strong id="sum">{{$d->unitPrice}}</strong></p>
                    <p class="text">数量：
                        <span class="num">
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default" id="minus" onclick="minus(this,'{{$d->productId}}','{{$d->id}}')">-</a>
            <input type="text" size="1" value="{{$d->account}}" id="account"/>
            <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default" id="plus" onclick="plus(this,'{{$d->productId}}')">+</a>
        </span>
                    </p>
                </div>
                <a href="javascript:;" class="x-cart-plist-del" id="del" onclick="del('{{$d->id}}','{{$d->productId}}')"></a>
            </div>
        </label>
    </div>
</li>
        @endforeach
</ul>
@else
        <div class="box" id="box">购物车里没有任何商品</div>
    @endif
</div>
</form>
<script>
$(function () {
    //总额
    sum();
});
//金额小计
function sum() {
    var sum = 0;
    var li = $(".x-cart-plist li");
    li.each(function (i) {
        var unitPrice = $(this).find("#sum").text();
        var account = $(this).find("#account").val();
        sum += unitPrice*account;
    });
    $("#count").text(sum)  ;
}
//单击数量减少
function minus(obj,productId,id) {
    var accountObj = $(obj).next().val();
    var account = parseInt(accountObj)-1;
    $.post("{{url('wechat/shopCart')}}",{productId:productId,account:account},function () {
        if(account <= 0){
            $(obj).next().val(account);
            sum();//重新计算总金额
           del(id,productId); //删除商品
        }else{
            $(obj).next().val(account);
        }
        sum();//重新计算总金额
    })
}
//单击数量增加
    function plus(obj,productId) {
       var accountObj = $(obj).prev().val(); //数量input框
       var account = parseInt(accountObj)+1;
       $.get("{{url('wechat/shopCart/create')}}",{productId:productId,account:account},function () {
           $(obj).prev().val(account);
           sum();//重新计算总金额
       })
    }
//删除单个商品
    function del(id,productId) {
        $.post("{{url('wechat/shopCart')}}"+'/'+id,{"_method":"delete"},function () {
            $('#'+productId).remove();
        })
    }
 //删除所有商品
    function delAll() {
        $.post("{{url('wechat/shopCart')}}"+'/'+1,{"_method":"get"},function () {
           location.href="http://www.lylyg2017.cn/graduate/wechat"; //成功则返回商品中心
        })
    }
</script>
</body>
@endsection
