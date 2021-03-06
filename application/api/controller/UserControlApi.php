<?php

namespace app\api\controller;


use app\api\model\User;
use think\Controller;
use think\Session;

class UserControlApi extends Controller
{
    public function login() {
        if(request()->isPost()) {
            $res = (new User())->login(input('post.'));
            return json($res);
        }
        else {
            return json(['valid' => 0, 'msg' => '请用 post 方法']);
        }
    }

    public function reg() {
        if($this->request->isPost()) {
            $res = (new User())->reg(input('post.'));
            return json($res);
        }
        else {
            return json(['valid' => 0, 'msg' => '请用 post 方法']);
        }
    }

    public function logout() {
        $res1 = Session::delete('loginname');
        $res2 = Session::delete('nickname');
        if(!$res1 || !$res2)
            return json(['valid' => 0, 'msg' => '注销失败']);
        return json(['valid' => 1, 'msg' => '注销成功']);
    }

    public function failed(){
        return json(['valid' => 1000, 'msg' => '未登录']);
    }
}