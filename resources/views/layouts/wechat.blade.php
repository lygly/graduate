<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0" />
    <link href="{{asset('/resources/views/wechat/static/lib/weui/style/weui.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/resources/views/wechat/static/lib/swiper/css/swiper.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/resources/views/wechat/static/css/style.css')}}" rel="stylesheet" />
    <script type="text/javascript" src="{{asset('/resources/views/admin/style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('/app/org/layer/layer.js')}}"></script>{{--弹层控件--}}
   {{-- <script src="{{asset('/resources/views/wechat/static/lib/js/jquery.validate.min.js')}}"></script>--}}{{--jquery表单验证--}}{{--
    <script src="{{asset('/resources/views/wechat/static/lib/js/messages_zh.min.js')}}"></script>--}}{{--jquery表单验证中文提示--}}
</head>


@yield('content')

</html>