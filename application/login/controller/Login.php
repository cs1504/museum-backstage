<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 29/03/2018
 * Time: 8:59 PM
 */

namespace app\login\controller;


use app\api\model\User;

class Login
{
    public function login()
    {
        if(request()->isPost()){
            $res = (new User())->login(input('post.'));
            if($res['valid'])
            {
                //说明登录成功
                $this->success($res['msg'],'/index');exit;
            }else{
                //说明登录失败
                $this->error($res['msg']);exit;
            }
        }
        //加载我们登录页面
        return $this->fetch('login');
    }
}