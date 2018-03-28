<?php

namespace app\api\model;

use think\Model;

class News extends Model
{
    public function insert($data) {
        $res = Db::name('news')->insert($data);
        return ['valid'=>1,'msg'=>'插入成功'];
    }

}