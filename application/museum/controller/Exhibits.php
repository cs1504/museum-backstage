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

class Exhibits extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $exhibits = Db::table('exhibits')
                ->alias('e')
                ->join('museum m', 'e.museum_id = m.id')
                ->field('e.id, e.name, m.name as museum_name, e.introduce')
                ->select();

            $this->assign('exhibits', $exhibits);
            SysLog::Addlog('查看藏品总览页面', $this->request, 0);
            return $this->fetch('index');
        }
    }

    public function exhibits($id) {
        if($this->request->isGet()) {
            $exhibits = Db::table('exhibits')
                ->alias('e')
                ->where('e.id', $id)
                ->join('museum m', 'e.museum_id = m.id')
                ->field('e.id, e.name, m.name as museum_name, e.introduce')
                ->find();
            $this->assign('exhibits', $exhibits);
            $this->assign('id', $id);
            SysLog::Addlog('查看 id 为'.$id.'的藏品的详细信息', $this->request, 0);
            return $this->fetch('view');
        }

        if($this->request->isDelete()) {
            $res = Db::table('exhibits')->where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此藏品']);
            }
            $res = Db::table('exhibits')->delete($id);
            if(!$res) {
                SysLog::Addlog('删除ID 为'.$id.'的藏品', $this->request, 1);
                return json(['valid'=>0,'msg'=>'删除失败']);
            }
            SysLog::Addlog('删除ID 为'.$id.'的藏品', $this->request, 0);
            return json(['valid'=>1,'msg'=>'删除藏品成功']);
        }
    }

    public function search() {
        if($this->request->isGet()) {

        }
    }

    public function insert() {
        if($this->request->isPost()) {
            $res = (new \app\api\model\Exhibits())->insert(input('post.'));
            SysLog::Addlog('添加了新的藏品，ID 为'.$res['id'], $this->request, 0);
            $this->redirect('/exhibits/'.$res['id']);
        }
        return $this->fetch('insert');
    }

    public function modify($id) {
        $exhibits = Db::table('exhibits')->where('id', '=', $id)->find();
        $this->assign('exhibits', $exhibits);
        $this->assign('id', $id);
        if($this->request->isPost()) {
            $data = input('post.');
            $res = Db::table('exhibits')->where('id', $id)
                ->update(['name' => $data['name'], 'introduce' => $data['introduce']]);
            if($res) {
                SysLog::Addlog('修改 ID 为'.$id.'的藏品', $this->request, 0);
                $this->redirect('/exhibits/'.$id);
            }
            else {
                SysLog::Addlog('修改 ID 为'.$id.'的藏品', $this->request, 1);
                $this->error('修改失败');exit;
            }
        }
        return $this->fetch('modify');
    }

}