@extends('layouts.wechat')
@section('content')
<body>
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
                    <input type="radio" class="weui-check" name="addr" id="{{$d->id}}" value="{{$d->id}}">
                    <input type="hidden" value="{{$d->customerId}}">
                    <span class="weui-icon-checked"></span>
                </div>
            </label>
            @endforeach
        </div>
    </div>
    <script>
        $(function () {
            $(".addr").click(function () {
                var addrId = $(this).children('div.weui-cell__ft').children('input[name=addr]').val();
                var customerId = $("input:hidden").val();
                console.log(addrId);
            /*    $.get('http://www.lylyg2017.cn/graduate/wechat/shopCart/addr/' + customerId +'/'+ addrId,{},function () {

                });*/
            })
        })
    </script>
</body>
@endsection