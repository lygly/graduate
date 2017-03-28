@extends('layouts.wechat')
@section('content')
<form action="{{url('WeChat/shopCart')}}">
<div class="x-container">
<div class="x-pd-info1">
<div class="x-pd-info1-cover"><img  src="{{url('/'.$data->picUrl)}}"/></div>
<div class="x-pd-info1-text">
<p class="title">{{$data->productName}}</p>
<p class="price">{{$data->unitPrice}}</p>
</div>
</div>

<div class="x-pd-info2">
{{$data->remark}}
</div>
    <div class="weui-tabbar">
        <input type="button" class="weui-btn weui-btn_primary" style="background-color: #4b7cea;" value="加入购物车">
    </div>
</div>
</form>
    @endsection
