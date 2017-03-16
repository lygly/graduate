<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';  //修改默认表名
    protected $primaryKey = 'cate_id';  //修改默认主键
    public $timestamps = false;     //设置默认上传时间为FALSE
    protected $guarded = []; //排除不能批量填充的字段

    //处理分类的方法
    public function tree()
    {
        $categorys = $this->orderBy('cate_order','asc')->get();
        return $data = $this->getTree($categorys,'cate_name','cate_id','cate_pid');
    }

    //树形分类函数
    public function getTree($data,$field_name,$field_id,$field_pid,$pid=0){
        $arr = array();
        foreach ($data as $k =>$v){
            if ($v->$field_pid==$pid){
                $data[$k]["_".$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];  //把cate_pid为0 的数据存在这个数组里面
                foreach ($data as $m => $n){
                    if ($n->$field_pid == $v->$field_id){
                        $data[$m]["_".$field_name] = "├─".$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }

        };
        return $arr;
    }
}
