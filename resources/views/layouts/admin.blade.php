<!DOCTYPE html>
<html lang="en">  {{--后台模板文件--}}
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('/resources/views/admin/style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('/resources/views/admin/style/font/css/font-awesome.min.css')}}">
    {{--<link rel="stylesheet" href="{{asset('/app/org/jedate/skin/jedate.css')}}">--}}{{--日期控件--}}
    <script type="text/javascript" src="{{asset('/resources/views/admin/style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('/resources/views/admin/style/js/ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('/app/org/layer/layer.js')}}"></script>{{--弹层控件--}}
    <script type="text/javascript" src="{{asset('/app/org/jeDate/jedate.js')}}"></script>{{--日期控件--}}
</head>
<body>
@yield('content')
</body>
</html>