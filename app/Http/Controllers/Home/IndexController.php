<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use Illuminate\Http\Request;
class IndexController extends CommonController
{
    //首页
    public function index(){
        //点击量最高的6篇文章(站长推荐)
        $pics = Article::orderBy('art_view','desc')->take(6)->get();
        //图文列表5篇（带分页）
        $data = Article::orderBy('art_time','desc')->paginate(5);
        //友情链接
        $links = Links::orderBy('link_order','asc')->get();
        //网站配置项
        return view('home.index',compact('hot','new','pics','data','links'));
    }
    //列表页
    public function cate($cate_id)
    {
        $field = Category::find($cate_id);
        //查看次数自增
        Category::where('cate_id',$cate_id)->increment('cate_view');
        //图文列表4篇文章（带分页）
        $data = Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);
        //当前分类的子分类
        $submenu = Category::where('cate_pid',$cate_id)->get();
        return view('home.cate',compact('field','data','submenu'));
    }
    //文章详情页
    public function article($art_id){
        //当前文章的所有内容以及分类信息
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();  //first 获取的是一个一维数组
        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');
        //上一篇文章
        $article['pre'] = Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();
        //下一篇文章
        $article['next'] = Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();
        //相关文章
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();
        return view('home.new',compact('field','article','data'));
    }
}
