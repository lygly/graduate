@extends('layouts.wechat')
@section('content')
    <style>
        .hid{display: none;}
    </style>
<body>
<form action="{{url('wechat/shopCart/addr/'.session('customer_id'))}}" method="post">
    <div class="x-container">
        <div class="weui-cells__title">选择收货地址</div>
        <div class="weui-cells weui-cells_radio">
            @foreach( $data as $d)
            <label class="weui-cell weui-check__label addr" for="{{$d->id}}">
                <div class="weui-cell__bd">
                    <div class="weui-panel__bd addr">
                                <div class="weui-media-box_text" style="font-size: 13px;">
                                    <p>{{$d->province.$d->city.$d->district.$d->detailAddr}}</p>
                                    <p><span>{{$d->acceptName}}</span> <span>{{$d->tell}}</span></p>
                                </div>
                    </div>
                </div>
                <div class="weui-cell__ft">
                    <input type="radio" class="weui-check" name="addrId" id="{{$d->id}}" value="{{$d->id}}">
                    {{session(['customer_id'=>$d->customerId,'addrId'=>$d->id])}}
                    <input type="submit" class="hid">
                    <span class="weui-icon-checked"></span>
                </div>
            </label>
            @endforeach
        </div>
    </div>
</form>
</body>
<script>
    $(function () {
        $(".addr").click(function () {
            $("input:submit").submit();
        })
    })
</script>
@endsection