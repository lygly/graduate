@extends('layouts.wechat')
@section('content')
<div class="weui-tabbar x-tabbar">
<a href="javascript:;" class="weui-tabbar__item">
<i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-1"></i><p class="weui-tabbar__label">我的医狗儿</p>
</a>
<a href="javascript:;" class="weui-tabbar__item weui-bar__item_on">
<i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-2"></i><p class="weui-tabbar__label">产品中心</p>
</a>
<a href="javascript:;" class="weui-tabbar__item">
<i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-3"></i><p class="weui-tabbar__label">个人中心</p>
</a>
</div>

<div class="x-container">
<div class="x-pd-info1">
<div class="x-pd-info1-cover"><img  src="{{url('/'.$data->picUrl)}}"/></div>
<div class="x-pd-info1-text">
<p class="title">{{$data->productName}}</p>
<p class="price">{{$data->unitPrice}}</p>
</div>
</div>

<div class="x-pd-info2">
重庆先洋科技有限公司与大卫逊设计公司的设计师们针对这一退化性慢性病进行了研究，并最终设计研发出了“Engel 医狗儿” 可穿戴设备。
</div>
</div>
    @endsection
