<?php

namespace app\api\model;

use think\Model;
use think\db;

class Museum extends Model
{
    public function insert($data) {
        $validate = new \app\api\validate\Museum;
        //如果验证不通过
        if(!$validate->check($data)){
            return ['valid'=>0, 'msg'=>$validate->getError()];
        }
        $res = Db::name('museum')->insert($data);
        $id = Db::name('museum')->getLastInsID();
        if(!$res) {
            //说明在数据库未匹配到相关数据
            return ['valid' => 0, 'msg' => '注册失败，未知原因'];
        }
        return ['valid'=>1,'id' => $id, 'name' => $data['name'],'msg'=>'注册成功'];
    }
}