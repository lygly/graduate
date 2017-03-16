<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    // get admin/config   get方式过来的 后面是地址  全部配置项列表
    public function index(){
        $data = Config::orderBy('conf_order','asc')->get();  //获取所有数据
        //配置内容显示问题  思路：先判断是什么类型 再拼接成字符串 最后压入data中
        foreach ($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                   $data[$k]->_html = '<input class="lg" type="text" name="conf_content[]" value="'.$v->conf_content.'">'; //把name="conf_content"加[] 变成数组
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea class="lg" type="text" name="conf_content[]" >'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                  //  echo $v->field_value ;   1|开启,0|关闭
                   $arr = explode(',',$v->field_value);  //拆分字符串为数组
                  /* dd($arr);  array:2 [▼
                         0 => "1|开启"
                          1 => "0|关闭"
                          ]*/
                   $str = "";
                   foreach($arr as $m=>$n){
                       //$n  : "1|开启"
                       $arr1 = explode('|',$n);
                       $c = $v->conf_content == $arr1[0]?'checked':''; //
                       $str .= '<input type="radio" name="conf_content[]" value="'.$arr1[0].'"'.$c.'> '.$arr1[1].'　';
                   };
                   $data[$k] ->_html = $str;
                    break;
            }
        }
        return view('admin.config.index',compact('data'));
    }
    //修改配置项内容
    public function changeContent(){
        $input = Input::get();
        foreach ($input['conf_id'] as $k=>$v){
            Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);   //update()里面要提交一个数组
        };
        $this->putFile(); //把修改后的配置项内容写入文件
        return back()->with('errors','配置项更新成功！');
    }
    //把网站配置项写入配置文件
    public function putFile(){
         $config =  Config::pluck('conf_content','conf_name')->all(); //只取这两项
         $str1 = var_export($config,true);   //把数组转化成字符串
         $path = base_path().'\config\web.php';
         $str = '<?php return '.$str1.';';
         file_put_contents($path,$str);
    }
    //异步更改排序
    public function changeOrder(){
        $input = Input::all();
        $config = Config::find($input['conf_id']);
        $config->conf_order = $input['conf_order'];
        $re = $config->update();    //执行更新
        if ($re){
            $data = [
                'status'=>0,
                'msg'=>'配置项排序更新成功！'
            ];
        }else{
            $data = [
                'status'=>1,
                'msg'=>'配置项排序更新失败，请稍后重试！'
            ];
        }
        return $data;
    }
    //get admin/config/create  添加配置项
    public function create(){
       return view('admin.config.add');
    }
    //post admin/config 添加配置项提交方法
    public function store(){
        $input = Input::except('_token');
            //填写规则
            $rules = [
                'conf_title'=>'required',
                'conf_name'=>'required',
            ];
            //填写提示信息
            $message = [
                'conf_title.required'=>'配置项标题不能为空',
                'conf_name.required'=>'配置项名称不能为空',
            ];
            //表单提交验证
            $validator = Validator::make($input,$rules,$message);
            //如果填写通过了验证
            if ($validator->passes()){
                $re = Config::create($input);
                if($re){
                    return redirect('admin/config');
                }else{
                    return back()->with('errors','数据更新失败，请稍后重试！');
                }

                }else{
                    return back()->withErrors($validator);
                }
            }
    //get admin/config/{config}/edit   编辑配置项
    public function edit($conf_id){
       $field =  Config::find($conf_id);
       return view('admin.config.edit',compact('field'));

    }
    //put admin/config/{config}   更新配置项
    public function update($conf_id){
        $input = Input::except('_token','_method');
        $re = Config::where('conf_id',$conf_id) ->update($input);
        if($re){
            $this->putFile(); //把修改后的配置项内容写入文件
            return redirect('admin/config');
        }else{
            return back()->with('errors','数据更新失败，请稍后重试！');
        }

    }
    //delete admin/config/{config}  删除单个配置项
    public function destroy($conf_id){
         $re = Config::where('conf_id',$conf_id)->delete();
         if ($re){
             $this->putFile(); //把修改后的配置项内容写入文件
             $data = [
                 'status'=>0,
                 'msg'=>'配置项删除成功！'
             ];
         }else{
             $data = [
                 'status'=>1,
                 'msg'=>'配置项删除失败，请稍后重试S！'
             ];
         }
        return $data;

    }

    //get admin/config/{config}   显示单个配置项信息
    public function show(){

    }



}
