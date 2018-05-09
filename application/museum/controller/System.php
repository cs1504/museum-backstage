<?php

namespace app\museum\controller;

use app\common\controller\CommonController;
use app\common\SysLog;
use think\Db;
use app\common\Baksql;


class System extends CommonController
{
    public function setting() {
        if($this->request->isGet()) {
            $options = Db::table('options')->select();
            $this->assign('options', $options);
            SysLog::Addlog('查看系统配置项', $this->request, 0);
            return $this->fetch('setting');
        }
    }

    public function log($id=0) {
        if($this->request->isGet()) {
            if($id == 0) {
                $logs = Db::table('logs')
                    ->alias('l')
                    ->join('admin a', 'l.operator = a.id', 'LEFT')
                    ->order('l.operate_time desc')
                    ->field('l.id, l.operator as operator_id, a.loginname, a.nickname,
                    l.description, l.operate_time, l.ip, l.status')
                    ->select();
                $this->assign('logs', $logs);
                SysLog::Addlog('查看系统日志', $this->request, 0);
                return $this->fetch('log');
            }
        }

    }

    public function backup() {
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

        if($this->request->isPost()) {
            $file=['name'=>date('Ymd-His'),'part'=>1];
            $res = $sql->setFile($file)->backupDatabase();
            SysLog::Addlog('手动备份数据库', $this->request, 0);
            return json($res);
        }

        $this->assign('list', $sql->fileList());
        SysLog::Addlog('查看数据库备份情况', $this->request, 0);
        return $this->fetch('backup');
    }

    public function downloadSqlFile() {
        if($this->request->isPost()) {
            if(input('?post.time')) {
                $time = input('post.time');
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
                SysLog::Addlog('下载数据库备份'.input('post.time'), $this->request, 0);
                $sql->downloadFile($time);
            }
        }
    }

    public function deletesql() {
        if($this->request->isDelete()) {
            $time = input('delete.time');
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
            $res = $sql->delFile($time);
            SysLog::Addlog('删除数据库备份'.input('delete.time'), $this->request, 0);
            return json(['valid' => 1, 'msg' => $res]);
        }
    }


    public function restoresql() {
        if($this->request->isPost()) {
            $time = input('post.time');
            // 将数据从文件中一条一条读出来，执行
            sleep(2);
            SysLog::Addlog('还原数据库'.input('post.time'), $this->request, 0);
            return json(['valid' => 1, 'msg' => '还原成功']);
        }
    }
}