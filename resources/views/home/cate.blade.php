@extends('layouts.home')
@section('info')
    <title>{{$field->cate_name}}-{{Config::get('web.web_title')}}--{{Config::get('web.seo_title')}}</title>
    <meta name="keywords" content="{{$field->cate_keywords}}" />
    <meta name="description" content="{{$field->cate_description}}" />
@endsection
@section('content')
<article class="blogs">
    {{--“慢生活”不是懒惰，放慢速度不是拖延时间，而是让我们在生活中寻找到平衡。--}}
    <h1 class="t_nav"><span>{{$field->cate_title}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$field->cate_id)}}" class="n2">{{$field->cate_name}}</a></h1>
    <div class="newblog left">
        @foreach($data as $d)
        <h2>{{$d->art_title}}</h2>
        <p class="dateview"><span>发布时间：{{date('Y-m-d',$d->art_time)}}</span><span>作者：{{$d->art_editor}}</span><span>分类：[<a href="{{url('cate/'.$field->cate_id)}}">{{$field->cate_name}}</a>]</span></p>
        <figure><img src="{{url($d->art_thumb)}}"></figure>
        <ul class="nlist">
            <p>{{$d->art_description}}</p>
            <a title="{{$d->art_title}}" href="{{url('a/'.$d->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
        </ul>
        <div class="line"></div>
        @endforeach
        <div class="blank"></div>
            {{--广告--}}
        {{--<div class="ad">
            <img src="images/ad.png">
        </div>--}}
            <div class="page">
                {{$data->links()}}
            </div>
    </div>
    <aside class="right">
        {{--当前分类下面的子分类--}}
        @if($submenu->all()) {{--调取数组里面的所有项目--}}
        <div class="rnav">
            <ul>
                @foreach($submenu as $k=>$s )
                <li class="rnav{{$k+1}}"><a href="{{url('cate/'.$s->cate_id)}}" target="_blank">{{$s->cate_name}}</a></li>
                @endforeach
            </ul>
        </div>
        @endif

          @parent
        </div>
    </aside>
</article>
@endsection