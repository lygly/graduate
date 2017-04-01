@extends('layouts.wechat')
@section('content')
<body>
<form action="{{url('wechat/shopCart/'.$data->productId)}}" method="post">
    <input type="hidden" name="_method" value="put">
<div class="x-container">
<div class="x-pd-info1" id="x-pd-info1" pid="{{$data->id}}">
<div class="x-pd-info1-cover">
    <img id="info1-img" src="{{url('/'.$data->picUrl)}}"/>
    <input type="hidden" name="imgUrl" value={{"$data->picUrl"}}>
</div>
<div class="x-pd-info1-text">
    <p  class="title" id="title">{{$data->productName}}</p>
    <p class="price" id="price">{{$data->unitPrice}} 元</p>
<input type="hidden" name="productName" value="{{$data->productName}}">
<input type="hidden" name="unitPrice" value="{{$data->unitPrice}}">
</div>
</div>

<div class="x-pd-info2">
{{$data->remark}}
</div>
    <div class="weui-tabbar x-tabbar">
        <div class="page__bd page__bd_spacing" style="padding: 5px; width: 100%;">
        <input id="submit" type="submit" class="weui-btn weui-btn_primary" style="background-color: #4b7cea;" value="加入购物车">
        </div>
    </div>
</div>
</form>
</body>
    @endsection
