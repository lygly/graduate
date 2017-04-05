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
        <div class="weui-panel__hd">选择收货地址</div>
        <div class="weui-panel__bd addr">
            @foreach( $data as $d)
                <div class="weui-media-box weui-flex">
                    <i class="weui-icon-circle"></i>
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
        <div class="weui-panel">
            <div class="weui-panel__hd">选择收货地址</div>
            <div class="weui-panel__bd">
                <div class="weui-media-box weui-media-box_small-appmsg">
                    <div class="weui-cells">
                       {{-- <a class="weui-cell weui-cell_access" href="javascript:;">
                            <div class="weui-cell__hd">
                                <i class="weui-icon-success"></i>
                            </div>
                            <div class="weui-cell__bd weui-cell_primary">
                                <p>文字标题</p>
                            </div>
                            <span class="weui-cell__ft"></span>
                        </a>--}}
                        @foreach( $data as $d)
                        <a class="weui-cell weui-cell_access" href="javascript:;">
                            <div class="weui-cell__hd"><i class="weui-icon-circle"></i></div>
                            <div class="weui-cell__bd weui-cell_primary">
                                {{--<div class="weui-panel__hd weui-flex">--}}
                                    {{--<div class="weui-media-box weui-media-box_text weui-flex__item addr">--}}
                                        <p>{{$d->province.$d->city.$d->district.$d->detailAddr}}</p>
                                        <p><span>{{$d->acceptName}}</span> <span>{{$d->tell}}</span></p>
                                    {{--</div>--}}
                                {{--</div>--}}
                            </div>
                            <span class="weui-cell__ft"> <a class="placeholder" href="{{url('wechat/shopAddr/'.$d->id.'/edit')}}" style="vertical-align: middle;display: block;"><span style="display: block;">修改</span></a></span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
     {{--<div class="weui-tabbar x-tabbar">
         <div class="page__bd page__bd_spacing" style="padding: 5px; width: 100%;">
             <a href="{{url('wechat/profile')}}" class="weui-btn weui-btn_primary" style="background-color: #4b7cea;">返回个人中心</a>
         </div>
        </div>--}}
    </div>
</body>
@endsection