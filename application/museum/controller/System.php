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

    public function log($id=0) {
        if($this->request->isGet()) {
            if($id == 0) {
                $logs = Db::table('logs')
                    ->alias('l')
                    ->join('admin a', 'l.operator = a.id')
                    ->field('l.id, l.operator as operator_id, a.loginname, a.nickname,
                    l.description, l.operate_time, l.ip, l.status')
                    ->select();
                $this->assign('logs', $logs);
                return $this->fetch('log');
            }
        }

    }

    public function backup() {

    }
}