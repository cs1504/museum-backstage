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
        if($cpu == null)
            $cpu = 0;
        $this->assign('cpu', $cpu);
        $mem = \app\common\ServerStatus::getMemoryUsage();
        $this->assign('mem', $mem['mem']);
        $disk['free'] = \app\common\ServerStatus::getDiskFreeSpace(true);
        $disk['total'] = \app\common\ServerStatus::getDiskTotalSpace(true);
        $this->assign('disk', $disk);
        return $this->fetch('index');
    }

}
