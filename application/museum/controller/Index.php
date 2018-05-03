<?php
namespace app\museum\controller;

use think\Controller;
use think\Db;
use app\common\controller\CommonController;

class Index extends CommonController
{
    public function index()
    {
        $count['museum'] = Db::table('museum')->count();
        $count['exhibits'] = Db::table('exhibits')->count();
        $count['exhibition'] = Db::table('exhibition')->count();
        $count['news'] = Db::table('news')->count();
        $count['audio'] = Db::table('audio')->count();
        $count['user'] = Db::table('user')->count();


        $this->assign('count', $count);

        $cpu = \app\common\ServerStatus::getCpuUsage();
        dump($cpu);
        $this->assign('cpu', $cpu);
        return $this->fetch('index');
    }

}
