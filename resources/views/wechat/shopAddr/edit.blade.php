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
             <div data-toggle="distpicker">
             <div class="weui-cell">
                 <div class="weui-cell__hd">
                     <label for="province" class="weui-label">省份</label>
                 </div>
                 <div class="weui-cell__bd">
                     <select  id="province" class="weui-input" name="province">
                        {{-- <option value="{{$field->province}}" selected]></option>--}}
                     </select>
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
                         <textarea class="weui-textarea" name="detailAddr" placeholder="请输入详细地址" rows="3">{{$field->detailAddr}}</textarea>
                     </div>
             </div>
       </div>
         <div class="page__bd page__bd_spacing" style="padding: 15px; background-color: #fff;">
             <input type="submit" class="weui-btn weui-btn_primary" width="100%" value="确定" style="margin-bottom: 15px;">
             <input type="hidden" name="openId" value="{{$field->openId}}">
             <a href="javascript:;" onclick="delCate({{$field->id}})" class="weui-btn weui-btn_default" value="">删除</a>
         </div>
     </div>
 </form>
 <script src="{{url('/resources/views/wechat/static/lib/distpicker.data.min.js')}}"></script>
 <script src="{{url('/resources/views/wechat/static/lib/distpicker.min.js')}}"></script>
 <script>
     function delCate(cate_id) {
         layer.confirm('您确认要删除该地址吗？', {
             btn: ['确定','取消'] //按钮
         }, function(){
             $.post('{{url('wechat/shopAddr/')}}'+'/'+cate_id,{'_method':'delete'},function (data) {
                 if(data.status == 0){
                     layer.msg(data.msg, {icon: 6});
                     location.href = location.href;
                 }else{
                     layer.msg(data.msg, {icon: 5});
                 }
             });
         }, function(){

         });
     }
 </script>
 </body>
@endsection