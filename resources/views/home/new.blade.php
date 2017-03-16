@extends('layouts.home')
@section('info')
    <title>{{$field->art_title}}--{{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{$field->art_tag}}" />
    <meta name="description" content="{{$field->art_description}}" />
@endsection
@section('content')
<article class="blogs">
    <h1 class="t_nav"><span>您当前的位置：<a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;<a href="{{url('cate/'.$field->cate_id)}}">{{$field->cate_name}}</a></span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/'.$field->cate_id)}}" class="n2">{{$field->cate_name}}</a></h1>
    <div class="index_about">
        <h2 class="c_titile">{{$field->art_title}}</h2>
        <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d',$field->art_time)}}</span><span>编辑：{{$field->art_editor}}</span><span>查看次数：{{$field->art_view}}</span></p>
        <ul class="infos">
            {!! $field->art_content !!}
        </ul>
        <div class="keybq">
            <p><span>关键字词</span>：{{$field->art_tag}}</p>

        </div>
        <div class="ad"> </div>
        <div class="nextinfo">
            @if($article['pre'])
            <p>上一篇：<a href="{{url('a/'.$article['pre']->art_id)}}">{{$article['pre']->art_title}}</a></p>
            @else
            <span>没有上一篇了</span>
            @endif
            @if($article['next'])
            <p>下一篇：<a href="{{url('a/'.$article['next']->art_id)}}">{{$article['next']->art_title}}</a></p>
            @else
            <span>没有下一篇了</span>
            @endif
        </div>
        <div class="otherlink">
            <h2>相关文章</h2>
            <ul>
                @foreach($data as $d)
                <li><a href="{{url('a/'.$d->art_id)}}" title="{{$d->art_title}}">{{$d->art_title}}</a></li>
               @endforeach
            </ul>
        </div>
    </div>
    <aside class="right">
       @parent
        </div>
    </aside>
</article>
@endsection