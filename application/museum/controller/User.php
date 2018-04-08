<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 08/04/2018
 * Time: 1:04 PM
 */

namespace app\museum\controller;

use app\common\controller\CommonController;
use think\Db;

class User extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $user = \app\api\model\User::select();
            $this->assign('user', $user);
            return $this->fetch('index');
        }
    }
}