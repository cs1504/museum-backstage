<?php

namespace app\api\model;

use think\Model;
use think\Db;
use think\Session;

class Admin extends Model
{
    public function getRoleTextAttr() {
        $role = [0=>'超级管理员',1=>'管理员'];
        return $role[$this['role']];
    }

    public function login($data)
    {
        //1.执行验证
        $validate = new \app\api\validate\Admin;
        //如果验证不通过
        if(!$validate->check($data)){
            return ['valid'=>0,'msg'=>$validate->getError()];
        }

        //2.比对用户名和密码是否正确
        $userInfo = Admin::where('loginname', $data['loginname'])
            ->where('password',md5('museum'.$data['password']))
            ->find();

        if (!$userInfo) {
            //说明在数据库未匹配到相关数据
            return ['valid' => 0, 'msg' => '用户名或者密码不正确'];
        }

        //3.将用户信息存入到session中
        Session::set('id', $userInfo['id']);
        Session::set('loginname', $userInfo['loginname']);
        Session::set('nickname', $userInfo['nickname']);
        return ['valid'=>1,'msg'=>'登录成功', 'loginname'=>Session::get('loginname')];
    }

    public function reg($data) {
        //1.执行验证
        $validate = new \app\api\validate\Admin;
        //如果验证不通过
        if(!$validate->check($data)){
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        $data['password'] = md5('museum'.$data['password']);

        $res = Admin::where('loginname', $data['loginname'])->find();
        if($res) {
            return ['valid' => 0, 'msg' => '用户名已占用'];
        }

        $res = Db::name('admin')->insert($data);
        $id = Db::name('admin')->getLastInsID();
        if(!$res) {
            //说明在数据库未匹配到相关数据
            return ['valid' => 0, 'msg' => '注册失败，未知原因'];
        }
        return ['valid'=>1,'id' => $id, 'loginname' => $data['loginname'],'msg'=>'注册成功'];
    }

}