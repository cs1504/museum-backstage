<?php

namespace app\api\controller;


use app\api\model\User;
use think\Controller;

class UserControl extends Controller
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
}