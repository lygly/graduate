<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\ProductDetail;
use App\Http\Model\ProductProperty;
use App\Http\Model\ProductSpec;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ProductDetailController extends CommonController
{
    // get admin/productDetail   get方式过来的 后面是地址  全部商品清单列表
    public function index(){

    }
    //get admin/productDetail/create  添加商品清单
    public function create(){
        $data = ProductProperty::join('p_productspec','p_productspec.id','=','p_productproperty.specId')
        ->join('sys_dictionary','sys_dictionary.id','=','p_productproperty.colorId')
        ->select('p_productproperty.*','sys_dictionary.names','p_productspec.spec')
        ->get(); //读取规格
        return view('admin.productDetail.add',compact('data'));
    }
    //post admin/productDetail 添加商品清单提交方法
    public function store(){
        $input = Input::except('_token','PHPSESSID');
        $input['startDate']=strtotime($input['startDate']);
        $input['endDate']=strtotime($input['endDate']);
        $productId = $input['productId'];
        //dd($input);
        //填写规则
        $rules = [
            'batchNo'=>'required',
            'propertyId'=>'required',   //art_title 字段必填
        ];
        //填写提示信息
        $message = [
            'batchNo.required'=>'批次号不能为空',
            'propertyId.required'=>'规格属性不能为空',
        ];
        //表单提交验证
        $validator = Validator::make($input,$rules,$message);
        //如果填写通过了验证
        if ($validator->passes()){
            $re = ProductDetail::create($input);
            if ($re){
                return redirect('admin/productDetail/'.$productId);  //返回到商品清单列表页面
            }else{
                return back()->with('errors','数据更新失败，请稍后重试！');
            }
        }else{
            return back()->withErrors($validator);  //返回错误信息
        }
    }
    //get admin/productDetail/{productDetail}/edit   修改商品清单
    public function edit($id){
        $data = ProductProperty::join('p_productspec','p_productspec.id','=','p_productproperty.specId')
            ->join('sys_dictionary','sys_dictionary.id','=','p_productproperty.colorId')
            ->select('p_productproperty.*','sys_dictionary.names','p_productspec.spec')
            ->get(); //读取规格
        $field =  ProductDetail::find($id);
        return view('admin.productDetail.edit',compact('field','data'));

    }
    //put admin/productDetail/{productDetail}   更新商品清单
    public function update($id){
        $input = Input::except('_token','_method');//接收网页更改的数据
        $input['startDate']=strtotime($input['startDate']);
        $input['endDate']=strtotime($input['endDate']);
       // dd($input);
        $productId = $input['productId'];
        $re = ProductDetail::where('id',$id) ->update($input);
        if($re){
            return redirect('admin/productDetail/'.$productId);
            // return redirect('admin/productDetail');
        }else{
            return back()->with('errors','商品清单更新失败，请稍后重试！');
        }

    }
    //delete admin/productDetail/{productDetail}  删除单个分类
    public function destroy($id){
        $re = ProductDetail::where('id',$id)->delete();
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'商品清单删除成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'商品清单删除失败，请稍后重试S！'
            ];
        }
        return $data;

    }
    //get admin/productDetail/{productDetail}   显示单个分类信息
    public function show($id){
        $data = ProductDetail::join('p_productproperty','p_productproperty.id','=','p_productdetail.propertyId')
            ->join('p_productspec','p_productspec.id','=','p_productproperty.specId')
            ->join('sys_dictionary','sys_dictionary.id','=','p_productproperty.colorId')
            ->select('p_productdetail.*','p_productproperty.unitPrice','sys_dictionary.names','p_productspec.spec')
            ->orderBy('startDate','desc')
            ->paginate(5); //读取数据按ID倒叙显示并且每一页显示5条记录
        session(['productId'=>$id]); //商品ID
        //dd(session('productId'));
        return view('admin.productDetail.index',compact('data'));
    }
}
