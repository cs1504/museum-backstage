<?php

namespace app\api\model;


use think\Model;
use think\Db;

class User extends Model
{
    public function getStatusTextAttr() {
        $status = [0=>'正常',1=>'禁用'];
        return $status[$this['status']];
    }

    public function login($data)
    {
        //1.执行验证
        $validate = new \app\api\validate\User;
        //如果验证不通过
        if(!$validate->check($data)){
            return ['valid'=>0,'msg'=>$validate->getError()];
        }

        //2.比对用户名和密码是否正确
        $userInfo = User::where('loginname', $data['loginname'])
            ->where('password',md5('museum'.$data['password']))
            ->find();

        if (!$userInfo) {
            //说明在数据库未匹配到相关数据
            return ['valid' => 0, 'msg' => '用户名或者密码不正确'];
        }
        // cookie session

        session('loginname', $userInfo['loginname'], 'think_');
        session('nickname', $userInfo['nickname'], 'think_');

        return ['valid'=>1,'msg'=>'登录成功'];
    }

    public function reg($data) {
        //1.执行验证
        $validate = new \app\api\validate\User;
        //如果验证不通过
        if(!$validate->check($data)){
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        $data['password'] = md5('museum'.$data['password']);

        $res = User::where('loginname', $data['loginname'])->find();
        if($res) {
            return ['valid' => 0, 'msg' => '用户名已占用'];
        }

        $res = Db::name('user')->insert($data);
        $id = Db::name('user')->getLastInsID();

        if(!$res) {
            //说明在数据库未匹配到相关数据
            return ['valid' => 0, 'msg' => '注册失败，未知原因'];
        }
        return ['valid'=>1,'id' => $id, 'loginname' => $data['loginname'],'msg'=>'注册成功'];
    }
}