<?php

namespace app\api\model;

use think\Model;
use think\Db;

class News extends Model
{
    public function insert($data) {
        $res = Db::name('news')->insert($data);
        if(!$res) {
            return json(['valid'=>0,'msg'=>'插入失败']);
        }
        $id = Db::name('museum')->getLastInsID();
        return ['valid'=>1,'id' => $id, 'title' => $data['title'], 'msg'=>'插入成功'];
    }

}