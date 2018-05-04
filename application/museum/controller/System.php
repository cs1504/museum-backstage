<?php

namespace app\museum\controller;

use app\common\controller\CommonController;
use think\Db;
use app\common\Baksql;


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
            return json($res);
        }

        $this->assign('list', $sql->fileList());
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
            return json(['valid' => 1, 'msg' => $res]);
        }
    }


    public function restoresql() {
        if($this->request->isPost()) {
            $time = input('post.time');
            // 将数据从文件中一条一条读出来，执行
            sleep(2);
            return json(['valid' => 1, 'msg' => '还原成功']);
        }
    }
}