<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ShoppingAddress extends Model
{
    protected $table = 'u_address';  //修改默认表名
    protected $primaryKey = 'id';  //修改默认主键
    public $timestamps = false;     //设置默认上传时间为FALSE
    protected $guarded = []; //排除不能批量填充的字段
}
