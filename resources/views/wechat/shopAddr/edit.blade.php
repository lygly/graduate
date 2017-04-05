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
 <form action="{{url('wechat/shopAddr/'.$field->id)}}" method="post">
     <input type="hidden" name="_method" value="put">
     <div class="x-container">
         <div class="weui-cells">
             <div class="weui-cell">
                 <div class="weui-cell__hd"><label for="acceptName" class="weui-label">收货人</label></div>
                 <div class="weui-cell__bd">
                     <input class="weui-input" name="acceptName" placeholder="请输入收货人" value="{{$field->acceptName}}">
                 </div>
             </div>
             <div class="weui-cell tell">
                 <div class="weui-cell__hd"><label for="tell" class="weui-label">电话号码</label></div>
                 <div class="weui-cell__bd">
                     <input class="weui-input" name="tell" type="number" pattern="[0-9]*" placeholder="请输入号码" value="{{$field->tell}}"/>
                 </div>
             </div>
             <div id="distpicker">
             <div class="weui-cell">
                 <div class="weui-cell__hd">
                     <label for="province" class="weui-label">省份</label>
                 </div>
                 <div class="weui-cell__bd">
                     <select  id="province" class="weui-input" name="province"></select>
                     <input type="hidden" id="province1" value="{{$field->province}}">
                 </div>
             </div>
             <div class="weui-cell">
                 <div class="weui-cell__hd">
                     <label for="city" class="weui-label">市</label>
                 </div>
                 <div class="weui-cell__bd">
                     <select  id="city" class="weui-input" name="city"></select>
                     <input type="hidden" id="city1" value="{{$field->city}}">
                 </div>
             </div>
             <div class="weui-cell">
                 <div class="weui-cell__hd">
                     <label for="district" class="weui-label">区/县</label>
                 </div>
                 <div class="weui-cell__bd">
                     <select id="district" class="weui-input" name="district"></select>
                     <input type="hidden" id="district1" value="{{$field->district}}">
                 </div>
             </div>
          </div>
             <div class="weui-cell">
                 <div class="weui-cell__hd">
                     <label for="detailAddr" class="weui-label">详细地址</label>
                 </div>
                     <div class="weui-cell__bd">
                         <textarea class="weui-textarea" name="detailAddr" placeholder="请输入详细地址" rows="3">{{$field->detailAddr}}</textarea>
                     </div>
             </div>
       </div>
         <div class="page__bd page__bd_spacing" style="padding: 15px; background-color: #fff;">
             <input type="submit" class="weui-btn weui-btn_primary"  value="确定" style="margin-bottom: 15px; background-color: #4b7cea;" onclick="return check(this.form)">
             <input type="hidden" id="openId" name="openId" value="{{$field->openId}}">
             <input type="hidden" name="customerId" value="{{$field->customerId}}">
             <a href="javascript:;" onclick="delCate({{$field->id}})" class="weui-btn weui-btn_default">删除</a>
         </div>
     </div>
 </form>
 <script src="{{url('/resources/views/wechat/static/lib/js/distpicker.js')}}"></script>
 <script>
     $(function () {
         //设置三级联动初始值
        var province = $('#province1').val();
        var city = $('#city1').val();
        var district = $('#district1').val();
        $('#distpicker').distpicker({
            province: province,
            city: city,
            district: district
        });
     });
     function delCate(cate_id) {
         var open_id = $('#openId').val();
         layer.confirm('您确认要删除该地址吗？', {
             btn: ['确定','取消'] //按钮
         }, function(){
             $.post('{{url('wechat/shopAddr/')}}'+'/'+cate_id,{'_method':'delete'},function (data) {
                 if(data.status == 0){
                     layer.msg(data.msg, {icon: 6});
                     location.href = "http://www.lylyg2017.cn/graduate/wechat/shopAddr/"+open_id;
                 }else{
                     layer.msg(data.msg, {icon: 5});
                 }
             });
         }, function(){

         });
     }
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