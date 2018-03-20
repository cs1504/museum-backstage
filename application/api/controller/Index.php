<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 14/03/2018
 * Time: 7:13 PM
 */

namespace app\api\controller;


use app\api\model\User;
use think\Controller;

class Index extends Controller
{
    public function hello()
    {
//        $user = new User();
//        $user->loginname     = 'thinkphp';
//        $user->email    = 'thinkphp@qq.com';
//        $user->save();
        $user = User::where('loginname', 'wyh0655')->find();
        return json($user);
    }
}