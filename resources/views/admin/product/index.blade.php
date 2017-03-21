@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 商品管理 &raquo; 商品管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>商品列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/product/create')}}"><i class="fa fa-plus"></i>新增商品</a>
                    <a href=""><i class="fa fa-recycle"></i>刷新</a>
                    {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">产品号</th>
                        <th class="tc">产品名称</th>
                        <th class="tc">产品类型</th>
                        <th class="tc">数量</th>
                        <th class="tc">单位</th>
                        <th class="tc">产品说明</th>
                        <th class="tc">创建人</th>
                        <th class="tc">创建时间</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $k=> $v)
                    <tr>
                        <td class="tc">{{$k+1}}</td>
                        <td class="tc">
                            {{$v->productCode}}
                        </td>
                        <td class="tc">{{$v->productName}}</td>
                        <td class="tc">{{$v->names}}</td>
                        <td class="tc">{{$v->account}}</td>
                        <td class="tc">{{$v->unit}}</td>
                        <td class="tc">{{$v->remark}}</td>
                        <td class="tc">{{$v->createPerson}}</td>
                        <td class="tc">{{date('Y-m-d',intval($v->createDate))}}</td>
                        <td>
                            <a href="{{url('admin/product/'.$v->id.'/edit')}}"><i class="fa fa-pencil-square-o"></i>修改</a>
                            <a href="{{url('admin/productProperty/'.$v->id)}}"><i class="fa fa-th"></i>属性</a>
                            <a href="{{url('admin/productDetail/'.$v->id)}}"><i class="fa  fa-list"></i>清单</a>
                            <a href="{{url('admin/productPhoto/'.$v->id)}}"><i class="fa  fa-file-image-o"></i>产品图</a>
                            <a href="javascript:;"onclick="delArt({{$v->id}})"><i class="fa  fa-times"></i>删除</a>
                        </td>
                    </tr>
                    @endforeach

                </table>

                <div class="page_list">
                    {{$data->links()}}
                    <style>
                        .result_content ul li span {
                            padding: 6px 12px;
                        }
                    </style>
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        //删除商品
        function delArt(art_id) {
            layer.confirm('您确认要删除这篇商品吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{url('admin/product/')}}'+'/'+art_id,{'_method':'delete','_token':'{{csrf_token()}}'},function (data) {
                    if(data.status == 0){
                        layer.msg(data.msg, {icon: 6});
                        location.href = location.href;
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
            }, function(){

            });
        }
    </script>


@endsection