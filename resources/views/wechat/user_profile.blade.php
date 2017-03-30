@extends('layouts.wechat')
@section('content')
    <body>
<div class="x-container">
    <form action="{{url('wechat/updateProfile')}}" method="post">
<div class="weui-cells x-up-list">
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd">头像</div>
<div class="weui-cell__ft"><img class="avatar" src="{{$data->headimgurl}}" alt="avatar" /></div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd">昵称</div>
<div class="weui-cell__ft">{{$data->nickName}}</div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd">性别</div>
<div class="weui-cell__ft">
    <select name="sex" id="">
        <option value="1" @if($data->sex == 1) selected @endif>女</option>
        <option value="2" @if($data->sex == 2) selected @endif>男</option>
    </select>
</div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd">所在地区</div>
<div class="weui-cell__ft">重庆 九龙坡</div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd">生日</div>
<div class="weui-cell__ft">{{$data->birthday}}</div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd">体重</div>
<div class="weui-cell__ft">{{$data->weight}}</div>
</a>
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd">身高</div>
<div class="weui-cell__ft">{{$data->height}}</div>
</a>
</div>

<div class="weui-cells x-up-list">
<a class="weui-cell weui-cell_access" href="javascript:;">
<div class="weui-cell__bd">地址</div>
<div class="weui-cell__ft">{{$data->addr}}</div>
</a>
</div>
    </form>
</div>
    </body>
@endsection