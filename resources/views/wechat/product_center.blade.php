@extends('layouts.wechat')
@section('content')
<div class="weui-tabbar x-tabbar">
<a href="{{url('/wechat/about')}}" class="weui-tabbar__item">
<i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-1"></i><p class="weui-tabbar__label">关于我们</p>
</a>
<a href="javascript:;" class="weui-tabbar__item weui-bar__item_on">
<i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-2"></i><p class="weui-tabbar__label">产品中心</p>
</a>
<a href="{{url('/wechat/profile')}}" class="weui-tabbar__item">
<i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-3"></i><p class="weui-tabbar__label">个人中心</p>
</a>
</div>

<div class="x-container">
<div class="swiper-container x-pc-slider" id="slider1">
<div class="swiper-wrapper">
    @foreach($data as $d)
<div class="swiper-slide"><a href="{{url('/wechat/p/'.$d->productId)}}"><img src="{{url('/'.$d->picUrl)}}" alt="Slide 1" /></a></div>
    @endforeach
</div>
<div class="swiper-pagination"></div>
</div>

<div class="x-pc-list">
    @foreach($field as $f)
<a href="{{url('/wechat/p/'.$f->productId)}}" class="x-pc-list-item">
<span class="image"><img  src="{{url('/'.$f->picUrl)}}"/></span>
<span class="title">{{$f->productName}}</span>
<span class="price">{{$f->unitPrice}}</span>
</a>
    @endforeach
</div>
</div>


<script src="{{asset('/resources/views/wechat/static/lib/swiper/js/swiper.min.js')}}"></script>
<script>
var swiper = new Swiper('#slider1', {
	pagination: '#slider1>.swiper-pagination',
	paginationClickable: true
});
</script>
@endsection