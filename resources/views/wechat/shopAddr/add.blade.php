@extends('layouts.wechat')
@section('content')
    <style>
        .tell:after{
            content: " ";
            position: absolute;
            left: 0;
            bottom: 0;
            right: 0;
            height: 1px;
            border-bottom: 1px solid #d9d9d9;
            color: #d9d9d9;
            -webkit-transform-origin: 0 0;
            transform-origin: 0 0;
            -webkit-transform: scaleY(.5);
            transform: scaleY(.5);
            left: 15px;
        }
    </style>
     <body>
 <form action="{{url('wechat/shopAddr')}}" method="post">
     <div class="x-container">
         <div class="weui-cells">
             <div class="weui-cell">
                 <div class="weui-cell__hd"><label for="acceptName" class="weui-label">收货人</label></div>
                 <div class="weui-cell__bd">
                     <input class="weui-input" name="acceptName" placeholder="请输入收货人">
                 </div>
             </div>
             <div class="weui-cell tell">
                 <div class="weui-cell__hd"><label for="tell" class="weui-label">电话号码</label></div>
                 <div class="weui-cell__bd">
                     <input class="weui-input" name="tell" type="number" pattern="[0-9]*" placeholder="请输入号码"/>
                 </div>
             </div>
             <div data-toggle="distpicker">
             <div class="weui-cell">
                 <div class="weui-cell__hd">
                     <label for="province" class="weui-label">省份</label>
                 </div>
                 <div class="weui-cell__bd">
                     <select  id="province" class="weui-input" name="province"></select>
                 </div>
             </div>
             <div class="weui-cell">
                 <div class="weui-cell__hd">
                     <label for="city" class="weui-label">市</label>
                 </div>
                 <div class="weui-cell__bd">
                     <select  id="city" class="weui-input" name="city"></select>
                 </div>
             </div>
             <div class="weui-cell">
                 <div class="weui-cell__hd">
                     <label for="district" class="weui-label">区/县</label>
                 </div>
                 <div class="weui-cell__bd">
                     <select id="district" class="weui-input" name="district"></select>
                 </div>
             </div>
          </div>
             <div class="weui-cell">
                 <div class="weui-cell__hd">
                     <label for="detailAddr" class="weui-label">详细地址</label>
                 </div>
                     <div class="weui-cell__bd">
                         <textarea class="weui-textarea" name="detailAddr" placeholder="请输入详细地址" rows="3"></textarea>
                     </div>
             </div>
       </div>
         <div class="weui-tabbar x-tabbar">
             <input type="submit" class="weui-btn weui-btn_primary" value="确定" onclick="return check(this.form)">
             <input type="hidden" name="openId" value="{{session('open_id')}}">
         </div>
     </div>
 </form>
 <script src="{{url('/resources/views/wechat/static/lib/js/distpicker.js')}}"></script>
 <script>
   function check(form){
       if(form.acceptName.value ==''){
           layer.alert('请填写收货人姓名', {
               skin: 'layui-layer-molv' //样式类名
               ,closeBtn: 0
           });
           form.acceptName.focus();
           return false;
       }
       if(form.tell.value ==''){
           layer.alert('请填写电话号码', {
               skin: 'layui-layer-molv' //样式类名
               ,closeBtn: 0
           });
           form.tell.focus();
           return false;
       }
       if(form.province.value ==''){
           layer.alert('请选择省份', {
               skin: 'layui-layer-molv' //样式类名
               ,closeBtn: 0
           });
           form.province.focus();
           return false;
       }
       if(form.city.value ==''){
           layer.alert('请选择城市', {
               skin: 'layui-layer-molv' //样式类名
               ,closeBtn: 0
           });
           form.city.focus();
           return false;
       }
       if(form.district.value ==''){
           layer.alert('请选择区县', {
               skin: 'layui-layer-molv' //样式类名
               ,closeBtn: 0
           });
           form.district.focus();
           return false;
       }
       if(form.detailAddr.value ==''){
           layer.alert('请填写详细地址', {
               skin: 'layui-layer-molv' //样式类名
               ,closeBtn: 0
           });
           form.detailAddr.focus();
           return false;
       }
       return true;
   }
 </script>
 </body>
@endsection