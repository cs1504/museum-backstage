<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 06/04/2018
 * Time: 12:12 AM
 */

namespace app\museum\controller;

use app\common\controller\CommonController;
use app\common\SysLog;
use think\Db;

class Exhibition extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $exhibition = Db::table('exhibition')
                ->alias('e')
                ->join('museum m', 'e.museum_id = m.id')
                ->field('e.id, e.name, m.name as museum_name, e.time, e.address, e.introduce')
                ->select();

            $this->assign('exhibition', $exhibition);
            SysLog::Addlog('查看展览总览页面', $this->request, 0);
            return $this->fetch('index');
        }
    }

    public function exhibition($id) {
        if($this->request->isGet()) {
            $exhibition = Db::table('exhibition')
                ->alias('e')
                ->where('e.id', $id)
                ->join('museum m', 'e.museum_id = m.id')
                ->field('e.id, e.name, m.name as museum_name, e.time, e.address, e.introduce')
                ->find();
            $this->assign('exhibition', $exhibition);
            $this->assign('id', $id);
            SysLog::Addlog('查看 id 为'.$id.'的展览的详细信息', $this->request, 0);
            return $this->fetch('view');
        }

        if($this->request->isDelete()) {
            $res = Db::table('exhibition')->where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此展览']);
            }
            $res = Db::table('exhibition')->delete($id);
            if(!$res) {
                SysLog::Addlog('删除ID 为'.$id.'的展览', $this->request, 1);
                return json(['valid'=>0,'msg'=>'删除失败']);
            }
            SysLog::Addlog('删除ID 为'.$id.'的展览', $this->request, 0);
            return json(['valid'=>1,'msg'=>'删除展览成功']);
        }
    }

    public function search() {
        if($this->request->isGet()) {

        }
    }

    public function insert() {
        if($this->request->isPost()) {
            $res = (new \app\api\model\Exhibition())->insert(input('post.'));
            SysLog::Addlog('添加了新的展览，ID 为'.$res['id'], $this->request, 0);
            $this->redirect('/exhibition/'.$res['id']);
        }
        return $this->fetch('insert');
    }

    public function modify($id) {
        $exhibition = Db::table('exhibition')->where('id', '=', $id)->find();
        $this->assign('exhibition', $exhibition);
        $this->assign('id', $id);
        if($this->request->isPost()) {
            $data = input('post.');
            $res = Db::table('exhibition')->where('id', $id)
                ->update(['name' => $data['name'], 'introduce' => $data['introduce'], 'time' => $data['time'],
                    'address' => $data['address']]);
            if($res) {
                SysLog::Addlog('修改 ID 为'.$id.'的展览', $this->request, 0);
                $this->redirect('/exhibition/'.$id);
            }
            else {
                SysLog::Addlog('修改 ID 为'.$id.'的展览', $this->request, 1);
                $this->error('修改失败');exit;
            }
        }
        return $this->fetch('modify');
    }

}