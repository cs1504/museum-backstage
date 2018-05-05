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
use app\common\AudioCheck;
use think\Db;

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

    public function autoaudiocheck() {
        $audiooncheck = Db::query('SELECT * FROM `audio` WHERE `taskId` is NOT NULL AND `totext` is NULL');
        if($audiooncheck != null) {
            foreach($audiooncheck as $item) {
                $checkaudio = new AudioCheck();
                $checkres = $checkaudio->response($item['taskId'], $item['dataId']);
                if($checkres['code'] == 200) {
                    Db::table('audio')
                        ->where('id', $item['id'])
                        ->data([
                            'label' => $checkres['label'],
                            'labeltext' => $checkres['labeltext'],
                            'suggestion' => $checkres['suggestion'],
                            'totext' => $checkres['content']
                        ])
                        ->update();
                }
                elseif ($checkres['code'] == 280) {

                }
                elseif ($checkres['code'] == 400) {
                    Db::table('audio')
                        ->where('id', $item['id'])
                        ->data([
                            'totext' => $checkres['msg']
                        ])
                        ->update();
                }
                elseif ($checkres['code'] == 500) {

                }
            }
        }

        $audionotcheck = Db::query('SELECT * FROM `audio` WHERE `taskId` is NULL');
        if($audionotcheck != null) {
            foreach ($audionotcheck as $item) {
                $checkaudio = new AudioCheck();
                $checkres = $checkaudio->request($item['addr']);
                if(200 == $checkres['code']) {
                    Db::table('audio')
                        ->where('id', $item['id'])
                        ->data([
                            'taskId' => $checkres['taskId'],
                            'dataId' => $checkres['dataId']
                        ])
                        ->update();
                }
            }
        }
    }
}