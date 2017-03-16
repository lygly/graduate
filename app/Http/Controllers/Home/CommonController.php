<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Navs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct(){
//        各个页面的导航
        $navs = Navs::orderBy('nav_id','asc')->get();
        View::share('navs',$navs);
        //点击量最高的5篇文章
        $hot = Article::orderBy('art_view','desc')->take(5)->get();
        View::share('hot',$hot);
        //最新发布文章8篇
        $new = Article::orderBy('art_time','desc')->take(8)->get();
        View::share('new',$new);
    }
}
