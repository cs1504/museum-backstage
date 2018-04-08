<?php

namespace app\api\model;


use think\Model;
use think\Db;

class Exhibition extends Model
{
    public function insert($data) {
        $res = Db::name('exhibition')->insert($data);
        $id = Db::name('exhibition')->getLastInsID();
        if(!$res) {
            //说明在数据库未匹配到相关数据
            return ['valid' => 0, 'msg' => '注册失败，未知原因'];
        }
        return ['valid'=>1,'id' => $id, 'name' => $data['name'],'msg'=>'注册成功'];
    }
}