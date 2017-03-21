<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ProductProperty extends Model
{
    //
    protected $table = 'p_productproperty';  //修改默认表名
    protected $primaryKey = 'id';  //修改默认主键
    public $timestamps = false;     //设置默认上传时间为FALSE
    protected $guarded = []; //排除不能批量填充的字段
    /*
     * 获取与属性关联的规格
     * */
    /*public function spec()
    {
        return $this->hasOne('App\Http\Model\ProductSpec','id','id');//第一个参数是要关联的模型，第二个参数是当前表要关联的字段，第三个参数是目标表要关联的字段
    }
    public function spec()
    {
        return $this->hasMany(ProductSpec::class, 'id', 'specId');
    }*/
}
