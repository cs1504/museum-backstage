<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 08/04/2018
 * Time: 2:14 PM
 */

namespace app\museum\controller;

use app\common\controller\CommonController;
use think\Db;


class System extends CommonController
{
    public function setting() {
        if($this->request->isGet()) {
            $options = Db::table('options')->select();
            $this->assign('options', $options);
            return $this->fetch('setting');
        }
    }

    public function log() {

    }

    public function backup() {

    }
}