<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';  //修改默认表名
    protected $primaryKey = 'user_id';  //修改默认主键
    public $timestamps = false;     //设置默认上传时间为FALSE
}
