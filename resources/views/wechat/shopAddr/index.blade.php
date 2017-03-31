@extends('layouts.wechat')
@section('content')
    <style>
        .addr{
            padding: 0;
        }
    </style>
<body>
    <div class="x-container">
        <div class="weui-panel weui-panel_access">
        <div class="weui-media-box addr">
            @foreach( $data as $d)
                <div class="weui-panel__hd weui-flex">
                    <div class="weui-media-box weui-media-box_text weui-flex__item addr">
                    <p>{{$d->province.$d->city.$d->district.$d->detailAddr}}</p>
                    <p><span>{{$d->acceptName}}</span> <span>{{$d->tell}}</span></p>
                    </div>
                    <a class="placeholder" href="{{url('wechat/shopAddr/'.$d->id.'/edit')}}" style="vertical-align: middle;display: block;"><span style="display: block;">修改</span></a>
                </div>
            @endforeach
        </div>
        </div>
        <div class="weui-cells">
            <a class="weui-cell weui-cell_access" href="{{url('wechat/shopAddr/create')}}">
                <div class="weui-cell__bd"><label for="addr" class="weui-label">新增收货地址</label></div>
                <div class="weui-cell__ft"></div>
            </a>
        </div>
    </div>
</body>
@endsection