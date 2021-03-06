@extends('layouts.wechat')
@section('content')
    <body>
    <div class="weui-tabbar x-tabbar">
        <a href="{{url('/wechat/about')}}" class="weui-tabbar__item">
            <i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-1"></i><p class="weui-tabbar__label">关于我们</p>
        </a>
        <a href="{{url('/wechat')}}" class="weui-tabbar__item">
            <i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-2"></i><p class="weui-tabbar__label">产品中心</p>
        </a>
        <a href="{{url('/wechat/profile')}}" class="weui-tabbar__item weui-bar__item_on">
            <i class="weui-tabbar__icon x-tabbar-icon x-tabbar-icon-3"></i><p class="weui-tabbar__label">个人中心</p>
        </a>
    </div>
<div class="x-container">
    <form action="{{url('wechat/updateProfile/'.$data->id)}}" method="post">
<div class="weui-cells x-up-list">
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd"><label for="" class="weui-label">头像</label></div>
<div class="weui-cell__ft"><img class="avatar" src="{{$data->headimgurl}}" alt="avatar" /></div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd"><label for="nickName" class="weui-label">昵称</label></div>
<div class="weui-cell__ft">
    <input type="text" name="nickName" class="weui-input" value="{{$data->nickName}}" placeholder="请输入昵称">
</div>
</a>
    <a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__bd"><label for="name" class="weui-label">姓名</label></div>
        <div class="weui-cell__ft">
            <input type="text" name="name" class="weui-input" value="{{$data->name}}" placeholder="请输入姓名">
        </div>
    </a>
    <a class="weui-cell weui-cell_access" href="javascript:;">
        <div class="weui-cell__bd"><label for="phone" class="weui-label">电话</label></div>
        <div class="weui-cell__ft">
            <input class="weui-input" name="phone" type="number" pattern="[0-9]*" value="{{$data->phone}}" placeholder="请输入电话号码"/>
        </div>
    </a>
<a class="weui-cell weui-cell_select weui-cell_access weui-cell_select-after " href="javascript:;">
<div class="weui-cell__hd"><label for="sex" class="weui-label">性别</label></div>
    <div class="weui-cell__bd">
    <select name="sex" id="" class="weui-select  weui-cell__ft">
        <option value="1" @if($data->sex == 1) selected @endif>男</option>
        <option value="2" @if($data->sex == 2) selected @endif>女</option>
    </select>
</div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd"><label for="" class="weui-label">所在地区</label></div>
<div class="weui-cell__ft">{{$data->province.' '.$data->city}}</div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__hd"><label for="birthday" class="weui-label"> 生日</label></div>
    <div class="weui-cell__bd weui-cell__ft">
    <input type="date" class="weui-input" name="birthday" value="{{date('Y-m-d',$data->birthday)}}">
    </div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd"><label for="weight" class="weui-label">体重</label></div>
<div class="weui-cell__ft"><input type="text" class="weui-input" name="weight" value="{{$data->weight}}" placeholder="请输入体重KG"></div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd"><label for="height" class="weui-label">身高</label></div>
<div class="weui-cell__ft"><input type="text" class="weui-input" name="height" value="{{$data->height}}" placeholder="请输入身高CM"></div>
</a>
</div>

<div class="weui-cells x-up-list">
<a class="weui-cell weui-cell_access" href="{{url('wechat/shopAddr/'.$data->id)}}">
<div class="weui-cell__bd"><label for="addr" class="weui-label">管理收货地址</label></div>
<div class="weui-cell__ft"></div>
</a>
</div>
        <div class="weui-cells">
            <div class="weui-cell" style="padding: 5px;">
            <input type="submit" class="weui-btn weui-btn_primary" style="background-color: #4b7cea;" value="确定" onclick="return check(this.form)">
            </div>
        </div>
    </form>
</div>
    </body>
    <script>
        function check(form) {
            if (form.name.value == '') {
                layer.alert('请填写姓名', {
                    skin: 'layui-layer-molv' //样式类名
                    , closeBtn: 0
                });
                form.name.focus();
                return false;
            }
            if (form.phone.value == '') {
                layer.alert('请填写电话号码', {
                    skin: 'layui-layer-molv' //样式类名
                    , closeBtn: 0
                });
                form.phone.focus();
                return false;
            }
        }
        </script>
@endsection