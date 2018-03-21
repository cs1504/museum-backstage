<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 21/03/2018
 * Time: 6:05 PM
 */

namespace app\api\controller;

use app\api\model\Admin;
use think\Controller;

class AdminControl extends Controller
{
    public function login() {
        if(request()->isPost()) {
            $res = (new Admin())->login(input('post.'));
            if($res['valid']) {
                // 登录成功
                $this->success($res['msg'],'/admin');exit;
            }
            else {
                // 登录失败
                $this->error($res['msg']);exit;
            }
        }
        
    }
}