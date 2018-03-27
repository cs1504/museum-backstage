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

class AdminControlApi extends Controller
{
    public function login() {
        if($this->request()->isPost()) {
            $res = (new Admin())->login(input('post.'));
            return json($res);
        }
        else {
            return json(['valid' => 0, 'msg' => '请用 post 方法']);
        }
    }

    public function reg() {
        if($this->request->isPost()) {
            $res = (new Admin())->reg(input('post.'));
            return json($res);
        }
        else {
            return json(['valid' => 0, 'msg' => '请用 post 方法']);
        }
    }
}