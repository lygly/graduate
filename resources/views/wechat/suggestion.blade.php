@extends('layouts.wechat')
@section('content')
    <form action="" method="post">
   <div class="x-container">
       <div class="weui-cells__title">反馈人</div>
       <div class="weui-cells">
           <div class="weui-cell weui-cell_select">
               <div class="weui-cell__bd">
                   <select class="weui-select" name="customerId">
                       <option selected="selected" value="{{session('customer_id')}}">
                           @if(empty($data->name))
                               {{$data->nickName}}
                               @endif
                               {{$data->name}}
                       </option>
                   </select>
               </div>
           </div>
       </div>
       <div class="weui-cells__title">反馈意见</div>
       <div class="weui-cells weui-cells_form">
           <div class="weui-cell">
               <div class="weui-cell__bd">
                   <textarea id="suggest" class="weui-textarea" placeholder="请输入文本" name="suggestionMember" rows="3"></textarea>
               </div>
           </div>
       </div>
       <div class="weui-tabbar x-tabbar">
           <div class="page__bd page__bd_spacing" style="padding: 5px; width: 100%;">
               <input id="submit" type="submit" class="weui-btn weui-btn_primary" style="background-color: #4b7cea;" value="确定">
           </div>
       </div>
   </div>
    </form>
    <script>
        $(function () {
            $("#submit").click(function () {
                var customerId = $("select option:selected").val();
                var suggestionMember = $("#suggest").val();
                //表单验证
                 if(suggestionMember==""){
                 layer.alert('请输入反馈意见', {
                 skin: 'layui-layer-molv' //样式类名
                 , closeBtn: 0
                 });
                     $("#suggest").focus();
                 return false;
                 }else{
                     $.post("{{url('/wechat/suggestion/store')}}",{"customerId":customerId,"suggestionMember":suggestionMember},function (data) {
                         if(data.status == 0){
                             layer.msg(data.msg, {icon: 6});
                         }else{
                             layer.msg(data.msg, {icon: 5});
                         }
                     })
                 }

            })
        });

    </script>
@endsection