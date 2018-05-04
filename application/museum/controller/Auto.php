<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 2018/5/4
 * Time: 10:11 PM
 */

namespace app\museum\controller;


use app\common\SysLog;
use think\Controller;
use app\common\Baksql;

class Auto extends Controller
{
    public function autobackup() {
        $config = array(
            'path' => 'static/databak/',
            //数据库备份路径
            'part' => 20971520,
            //数据库备份卷大小
            'compress' => 0,
            //数据库备份文件是否启用压缩 0不压缩 1 压缩
            'level' => 9,
        );
        $sql = new Baksql($config);
        $file=['name'=>date('Ymd-His'),'part'=>1];
        $res = $sql->setFile($file)->backupDatabase();
        if($res['valid'] == 1) {
            SysLog::Addlog('系统自动备份数据库成功', $this->request, 0);
            print_r('系统自动备份数据库成功');
        }
        else{
            SysLog::Addlog('系统自动备份数据库失败', $this->request, 1);
            print_r('系统自动备份数据库失败');
        }
    }
}