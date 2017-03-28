@extends('layouts.wechat')
@section('content')
<style>
    .about-body{
        /*margin:30px;*/
        background-color:#E9E9E9;
    }
    .about-div{
        margin: 30px 30px 0;
        text-align: center;
        background-color: white;
        border:1px solid #BFBFBF;
        box-shadow:2px 2px 3px #aaaaaa;
        border-radius:15px;
        padding: 10px;
    }
    .about-h1{
        color: #888a85;
    }
    .about{
        width:90%;
        margin-top: 5%;
    }
 </style>
<body class="about-body">
<div class="weui-tabbar x-tabbar">
    <a href="javascript:;" class="weui-tabbar__item weui-bar__item_on">
        <i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-1"></i><p class="weui-tabbar__label">关于我们</p>
    </a>
    <a href="{{url('/wechat')}}" class="weui-tabbar__item">
        <i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-2"></i><p class="weui-tabbar__label">产品中心</p>
    </a>
    <a href="{{url('/wechat/profile')}}" class="weui-tabbar__item">
        <i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-3"></i><p class="weui-tabbar__label">个人中心</p>
    </a>
</div>
<div class="x-container">
    <div class="about-div">
        <h1 class="about-h1">公司简介</h1>
        <img  class="about" src="{{url('/resources/views/wechat/static/img/seller_about.jpeg')}}" alt="">

    </div>

</div>
</body>
@endsection