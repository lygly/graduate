@extends('layouts.admin')
   @section('content')
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">医疗后台管理系统</div>
			<ul>
				<li><a href="{{url('/')}}"  target="_blank" class="active">首页</a></li>
				<li><a href="{{url('admin/info')}}" target="main">管理页</a></li>
			</ul>
		</div>
		<div class="top_right">
			<ul>
				<li>管理员：{{session('user.user_name')}}</li>
				<li><a href="{{url('admin/pass')}}" target="main">修改密码</a></li>
				<li><a href="{{url('admin/quit')}}">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
			<li>
				<h3><i class="fa fa-fw fa-list-ul"></i>订单管理</h3>
				<ul class="sub_menu">
					<li><a href="{{url('admin/order')}}" target="main"><i class="fa fa-fw fa-clipboard"></i>客户订单</a></li>
					</ul>
			</li>
            <li>
            	<h3><i class="fa fa-fw fa-list-ul"></i>商品管理</h3>
                <ul class="sub_menu">
					<li><a href="{{url('admin/productSpec')}}" target="main"><i class="fa fa-fw fa-share-alt-square"></i>规格定义</a></li>
					<li><a href="{{url('admin/product')}}" target="main"><i class="fa fa-fw fa-reorder"></i>商品管理</a></li>
					<li><a href="{{url('admin/product/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加商品</a></li>
                </ul>
            </li>
			<li>
				<h3><i class="fa fa-fw fa-clipboard"></i>个人中心</h3>
				<ul class="sub_menu">
					{{--<li><a href="{{url('admin/category/create')}}" target="main"><i class="fa fa-fw fa-puzzle-piece"></i>积分类型</a></li>
					<li><a href="{{url('admin/category')}}" target="main"><i class="fa fa-fw fa-qrcode"></i>积分详情</a></li>
					<li><a href="{{url('admin/article/create')}}" target="main"><i class="fa fa-fw fa-refresh"></i>积分兑换表</a></li>--}}
					<li><a href="{{url('admin/customer')}}" target="main"><i class="fa fa-fw  fa-user"></i>个人信息</a></li>
					<li><a href="{{url('admin/about')}}" target="main"><i class="fa fa-fw  fa-users"></i>关于我们</a></li>
					<li><a href="{{url('admin/suggestion')}}" target="main"><i class="fa fa-fw fa-pencil"></i>意见反馈</a></li>
				</ul>
			</li>
			<li>
				<h3><i class="fa fa-fw fa-wrench"></i>基础配置</h3>
				<ul class="sub_menu">
					<li><a href="{{url('admin/repository')}}" target="main"><i class="fa fa-fw fa-cubes"></i>题库</a></li>
					<li><a href="{{url('admin/dictionary')}}" target="main"><i class="fa fa-fw  fa-navicon"></i>类型管理</a></li>
				</ul>
			</li>
           {{-- <li>
            	<h3><i class="fa fa-fw fa-cog"></i>系统设置</h3>
                <ul class="sub_menu">
					<li><a href="{{url('admin/links')}}" target="main"><i class="fa fa-fw fa-cubes"></i>菜单管理</a></li>
					<li><a href="{{url('admin/navs')}}" target="main"><i class="fa fa-fw  fa-navicon"></i>角色管理</a></li>
                    <li><a href="{{url('admin/config')}}" target="main"><i class="fa fa-fw fa-cogs"></i>网站配置</a></li>
                </ul>
            </li>--}}
            <li>
            	<h3><i class="fa fa-fw fa-thumb-tack"></i>工具导航</h3>
                <ul class="sub_menu">
                    <li><a href="http://www.yeahzan.com/fa/facss.html" target="main"><i class="fa fa-fw fa-font"></i>图标调用</a></li>
                    <li><a href="http://hemin.cn/jq/cheatsheet.html" target="main"><i class="fa fa-fw fa-chain"></i>Jquery手册</a></li>
                    <li><a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a></li>
                    <li><a href="element.html" target="main"><i class="fa fa-fw fa-tags"></i>其他组件</a></li>
                </ul>
            </li>
        </ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
	</div>
	<!--主体部分 结束-->

	<!--底部 开始-->
	<div class="bottom_box">
		CopyRight © 2017. Powered By 重庆师范大学计算机信息与科学学院--刘尧
	</div>
    @endsection
	<!--底部 结束-->