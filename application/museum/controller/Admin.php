<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 08/04/2018
 * Time: 1:04 PM
 */

namespace app\museum\controller;

use app\common\controller\CommonController;
use app\common\SysLog;
use think\Db;

class Admin extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $adminuser = \app\api\model\Admin::select();
            $this->assign('adminuser', $adminuser);
            SysLog::Addlog('查看管理员总览页面', $this->request, 0);
            return $this->fetch('index');
        }
    }
}