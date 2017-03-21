@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 商品管理 &raquo; 商品管理
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加商品</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))   {{--如果错误信息是新密码验证错误--}}
                    @foreach($errors->all() as $message)
                        <p> {{$message}}</p>
                    @endforeach
                    @else
                        <p>{{$errors}}</p>   {{--错误信息是一个字符串--}}
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/product/create')}}"><i class="fa fa-plus"></i>新增商品</a>
                <a href="{{url('admin/product')}}"><i class="fa fa-arrow-left"></i>返回</a>
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/product')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>分类：</th>
                        <td>
                            <select name="productTypeId">
                                @foreach($data as $d)
                                    <option value="{{$d->id}}">{{$d->names}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>产品号：</th>
                        <td>
                            <input type="text"  name="productCode">
                            <span><i class="fa fa-exclamation-circle yellow"></i>产品号必须填写</span>
                        </td>
                    </tr>
                   <tr>
                       <th>产品名称：</th>
                       <td>
                           <input type="text" name="producName">
                       </td>
                   </tr>
                   {{-- <tr>
                        <th>数量：</th>
                        <td>
                            <input type="text" name="amount" disabled>
                        </td>
                    </tr>--}}
                    <tr>
                        <th>单位：</th>
                        <td>
                            <input type="text" name="unit">
                        </td>
                    </tr>
                    <tr>
                        <th>产品说明：</th>
                        <td>
                            <input class="lg" type="text" name="remark">
                        </td>
                    </tr>
                   <tr>
                       <th>缩略图：</th>
                       <td>
                           {{--上传文件插件--}}
                           <input type="text" size="50" name="pic">
                           <input id="file_upload" name="file_upload" type="file" multiple="true">
                           <script src="{{asset('app/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
                           <link rel="stylesheet" type="text/css" href="{{asset('app/org/uploadify/uploadify.css')}}">
                           <script type="text/javascript">
                               <?php $timestamp = time();?>
                               $(function() {
                                   $('#file_upload').uploadify({
                                       'buttonText' : '选择图片',
                                       'formData'     : {
                                           'timestamp' : '<?php echo $timestamp;?>',
                                           '_token'     : "{{csrf_token()}}"
                                       },
                                       'swf'      : "{{asset('app/org/uploadify/uploadify.swf')}}",
                                       'uploader' : "{{url('admin/upload')}}",
                                       'onUploadSuccess' : function(file, data, response) {
                                           $('input[name = pic]').val(data);
                                           $('#art_thumb_img').attr('src','/'+data);
                                       }
                                   });
                               });
                           </script>
                           <style>
                               .uploadify{display:inline-block;}
                               .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
                               table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
                           </style>
                       </td>
                   </tr>
                    <tr>
                        <th></th>
                        <td>
                            <img src="" alt="" id="art_thumb_img" style="max-width: 350px;max-height: 100px;">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

@endsection