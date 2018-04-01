<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 29/03/2018
 * Time: 8:59 PM
 */

namespace app\admin\controller;


use app\api\model\Admin;
use think\Controller;
use app\api\controller\AdminControlApi;

class Login extends Controller
{
    public function login()
    {
        if(request()->isPost()){
            $res = (new Admin())->login(input('post.'));
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

    public function logout() {
        $res = AdminControlApi::logout();
        $res = json_decode($res->getContent(), true);
        if($res['valid'])
            return $this->fetch('login');
        else
            $this->error($res['msg']);exit;
    }

    public function index() {
        return $this->fetch('index');
    }
}