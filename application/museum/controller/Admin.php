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

class Admin extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $adminuser = \app\api\model\Admin::select();
            $this->assign('adminuser', $adminuser);
            return $this->fetch('index');
        }
    }
}