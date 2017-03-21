<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    protected $table = 'sys_dictionary';  //修改默认表名
    protected $primaryKey = 'id';  //修改默认主键
    public $timestamps = false;     //设置默认上传时间为FALSE
    protected $guarded = []; //排除不能批量填充的字段

    //处理分类的方法
    public function tree()
    {
        $categorys = $this->orderBy('sort','asc')->get();
        return $data = $this->getTree($categorys,'names','id','pId');
    }
   /* //问答页面分类
    public function question(){
        $question = $this->where('pId',3)->orWhere('id',3)->orderBy('sort','asc')->get();//查出设备问题及其子类
        return $data = $this->getTree($question,'names','id','pId');
    }*/
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
    /*
     *
     *
    public function BelongsToProperty()
    {
        return $this->belongsTo(ProductProperty::class, 'id', 'colorId');
    }*/
}
