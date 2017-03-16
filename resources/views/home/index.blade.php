@extends('layouts.home')
@section('info')
    <title>{{Config::get('web.web_title')}}--{{Config::get('web.seo_title')}}</title>
    <meta name="keywords" content="{{Config::get('web.keywords')}}" />
    <meta name="description" content="{{Config::get('web.description')}}" />
@endsection
@section('content')
<div class="banner">
    <section class="box">
        <ul class="texts">
            <p>打了死结的青春，捆死一颗苍白绝望的灵魂。</p>
            <p>为自己掘一个坟墓来葬心，红尘一梦，不再追寻。</p>
            <p>加了锁的青春，不会再因谁而推开心门。</p>
        </ul>
        <div class="avatar"><a href="#"><span>后盾</span></a> </div>
    </section>
</div>
<div class="template">
    <div class="box">
        <h3>
            <p><span>站长</span>推荐 Recommend</p>
        </h3>
        <ul>
            @foreach($pics as $k=>$p)
            <li><a href="{{url('a/'.$p->art_id)}}"  target="_blank"><img src="{{url($p->art_thumb)}}"></a><span>{{$p->art_title}}</span></li>
            @endforeach
        </ul>
    </div>
</div>
<article>
    <h2 class="title_tj">
        <p>文章<span>推荐</span></p>
    </h2>
    <div class="bloglist left">
        @foreach($data as $d)
        <h3>{{$d->art_title}}</h3>
        <figure><img src="{{url($d->art_thumb)}}"></figure>
        <ul>
            <p>{{$d->art_description}}</p>
            <a title="{{$d->art_title}}" href="{{url('a/'.$d->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
        </ul>
        <p class="dateview"><span>{{date('Y-m-d',$d->art_time)}}</span><span>作者：{{$d->art_editor}}</span></p>
         @endforeach
        <div class="page">
            {{$data->links()}}
        </div>
    </div>
    <aside class="right">
             @parent {{--把模板中的东西显示出来--}}
            <h3 class="links">
                <p>友情<span>链接</span></p>
            </h3>
            <ul class="website">
                @foreach($links as $l)
                <li><a href="{{$l->link_url}}" target="_blank">{{$l->link_name}}</a></li>
                @endforeach
            </ul>
        </div>
    </aside>
</article>
@endsection