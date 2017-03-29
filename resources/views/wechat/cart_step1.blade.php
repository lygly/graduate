@extends('layouts.wechat')
@section('content')
<body>
<div class="x-cart-actionbar">
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

<ul class="x-cart-plist">
<!--<li>
<div class="x-cart-plist-cover"><img id="plist-img"/></div>
<div class="x-cart-plist-info" id="x-cart-plist-info">
<p class="title" id="title">先立可本草超声灸</p>
<p class="text" id="price">售价：<strong>3680</strong></p>
<p class="text" id="sum">小计：<strong>3680</strong></p>
    <p class="text">数量：<span class="num"><a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default">-</a></span><input type="text" size="1" value="1" /><span><a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default">+</a></span></p>
</div>
<a href="javascript:;" class="x-cart-plist-del"></a>
</li>-->
</ul>

<div class="x-cart-paddon">
<label><input type="checkbox" class="checkbox" /><span>签约治疗<strong>1200</strong></span></label>
</div>
    <div class="box" id="box">购物车里没有任何商品</div>
</div>
<style>
    .box{
        text-align: center;
    }
    .hide{
        display: none;
    }
</style>
<script src="{{url('/resources/views/wechat/static/lib/server.js')}}"></script>
<script src="{{url('/resources/views/wechat/static/lib/cookie.js')}}"></script>
<script>
    $(function () {
        var listObj = getAllData();
        console.log(listObj);
        var ul = $('.x-cart-plist');
        var paddon = $('.x-cart-paddon');
        var box = $('#box');
        if(getJsonLength(listObj) == 0) { //购物车为空
            ul.addClass('hide');
            paddon.addClass('hide');
        } else {
            box.className = "box hide";
            ul.removeClass('hide');
            paddon.removeClass('hide');
            for(var i = 0, len = listObj.length; i < len; i++) {
                var li = document.createElement("li");
                li.setAttribute("pid", listObj[i].pid);
                //{"pid":值,"pImg":值,"pName":值,"pDesc":值,"price":值,"pCount":1},
                li.innerHTML='<li>'+
                    '<div class="x-cart-plist-cover">'+
                    '<img id="plist-img" src="' + listObj[i].pImg+ '"/>'+
                    '</div>'+
                    '<div class="x-cart-plist-info" id="x-cart-plist-info">'+
                    '<p class="title" id="title">'+ listObj[i].pName +'</p>'+
                    '<p class="text" id="price">售价：<strong>'+ listObj[i].price +'</strong></p>'+
                    '<p class="text" id="sum">小计：<strong>3680</strong></p>'+
                    '<p class="text">数量：<span class="num"><a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default">-</a></span><input type="text" size="1" value="'+ listObj[i].pCount+'" /><span><a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_default">+</a></span></p>'+
                    '</div>'+
                    '<a href="javascript:;" class="x-cart-plist-del"></a>'+
                    '</li>';
                ul.appendChild(li);
            }
        }

    });
    //获取json的长度
    function getJsonLength(jsonData){

        var jsonLength = 0;

        for(var item in jsonData){

            jsonLength++;

        }

        return jsonLength;

    }
</script>
</body>
@endsection
