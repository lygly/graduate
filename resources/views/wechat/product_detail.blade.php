@extends('layouts.wechat')
@section('content')
<body>
<div class="x-container">
<div class="x-pd-info1" id="x-pd-info1" pid="{{$data->id}}">
<div class="x-pd-info1-cover"><img id="info1-img"  src="{{url('/'.$data->picUrl)}}"/></div>
<div class="x-pd-info1-text">
<p class="title" id="title">{{$data->productName}}</p>
<p class="price" id="price">{{$data->unitPrice}}</p>
</div>
</div>

<div class="x-pd-info2">
{{$data->remark}}
</div>
    <div class="weui-tabbar">
        <a id="submit"  class="weui-btn weui-btn_primary" style="width: 100%; background-color: #4b7cea;">加入购物车</a>
    </div>
</div>
<script src="{{url('/resources/views/wechat/static/lib/cookie.js')}}"></script>
<script src="{{url('/resources/views/wechat/static/lib/server.js')}}"></script>
{{--<script src="{{url('/resources/views/wechat/static/lib/add_cart.js')}}"></script>--}}
<script>
    $(function () {
        //约定好用名称为datas的cookie来存放购物车里的数据信息  datas里所存放的就是一个json字符串
        var listStr = cookieObj.get("datas");
        /*判断一下本地是否有一个购物车（datas），没有的话，创建一个空的购物车，有的话就直接拿来使用*/
        if(!listStr) { //没有购物车     datas  json
            cookieObj.set({
                name: "datas",
                value: "[]"
            });
            listStr = cookieObj.get("datas");
        }
        var listObj = JSON.parse(listStr); //数组
        $('#submit').click(function () {
            var pid = $('.x-pd-info1').attr('pid');//获取商品的id号
            if(checkObjByPid(pid)) {
                listObj = updateObjById(pid, 1);
               /* for(var i=0;i<listObj.length;i++){
                    console.log(listObj[i]);
                }*/
                listObj = getAllData();
                for(var i=0;i<listObj.length;i++){
                    console.log(i + listObj[i]);
                    console.log(JSON.stringify(listObj[i]))
                }
            } else {
                var imgSrc = $('#info1-img').src;
                var pName = $('#title').innerHTML;
                var price = $('#price').innerHTML;
                var obj = {
                    pid: pid,
                    pImg: imgSrc,
                    pName: pName,
                    pDesc: pName,
                    price: price,
                    pCount: 1
                };
                listObj.push(obj);
                listObj = updateData(listObj);
                for(var i=0;i<listObj.length;i++){
                    console.log(listObj[i]);
                }
            }
          $url = "{{url('/wechat/cart_step1')}}";
          $('#submit').attr('href',$url); //跳转
        })
    })
</script>
{{--<script>
    var submit = document.getElementById('submit');
    //约定好用名称为datas的cookie来存放购物车里的数据信息  datas里所存放的就是一个json字符串
    var listStr = cookieObj.get("datas");
    /*判断一下本地是否有一个购物车（datas），没有的话，创建一个空的购物车，有的话就直接拿来使用*/
    if(!listStr) { //没有购物车     datas  json
        cookieObj.set({
            name: "datas",
            value: "[]"
        });
        listStr = cookieObj.get("datas");
    }

    var listObj = JSON.parse(listStr); //数组

    submit.onclick = function() {

        var pid = document.getElementById('x-pd-info1').getAttribute("pid");//获取自定义属性
        if(checkObjByPid(pid)) {
            listObj = updateObjById(pid, 1);
           // alert(listObj.length);
            for(var i=0;i<listObj.length;i++){
               console.log(listObj[i]);
            }
        } else {
            var imgSrc = document.getElementById('info1-img').src;
            var pName = document.getElementById('title').innerHTML;
            // var pDesc = arrs[2].innerHTML;
            var price = document.getElementById('price').innerHTML;
            var obj = {
                pid: pid,
                pImg: imgSrc,
                pName: pName,
                pDesc: pName,
                price: price,
                pCount: 1
            };
            listObj.push(obj);
            listObj = updateData(listObj);
           for(var i=0;i<listObj.length;i++){
               console.log(listObj[i]);
           }
        }
        var url = "{{url('/resources/views/wechat/cart_step1.htm')}}";
        // var url = '/resources/views/wechat/cart_step1.htm';
       submit.setAttribute('href',url);

    };
</script>--}}
</body>
    @endsection
