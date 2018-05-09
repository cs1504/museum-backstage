<?php

namespace app\museum\controller;

use app\common\controller\CommonController;
use app\common\SysLog;
use think\Db;

class User extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $user = \app\api\model\User::select();
            $this->assign('user', $user);
            SysLog::Addlog('查看用户总览', $this->request, 0);
            return $this->fetch('index');
        }
    }

    public function user($id) {
        if($this->request->isGet()) {
            $user = Db::table('user')->where('id', $id)->find();
            $comment = Db::table('comment')
                ->alias('c')
                ->where('c.user_id', $id)
                ->join('user u', 'c.user_id = u.id')
                ->join('museum m', 'c.museum_id = m.id')
                ->field('c.id, c.coption, nickname, m.name as museum_name, c.status, c.user_ip, c.time, c.content, c.parent, u.avatar')
                ->select();
            $this->assign('user', $user);
            $this->assign('comment', $comment);
            $this->assign('id', $id);
            SysLog::Addlog('查看 ID 为'.$id.'的用户', $this->request, 0);
            return $this->fetch('view');
        }

        if($this->request->isDelete()) {
            $user = Db::table('user')->where('id', $id)->find();
            if(!$user) {
                return json(['valid'=>0,'msg'=>'没有此用户']);
            }
            $res = Db::table('user')->where('id', $id)->delete();
            if(!$res) {
                SysLog::Addlog('查看 ID 为'.$id.'的用户', $this->request, 1);
                return json(['valid'=>0,'msg'=>'删除失败']);
            }
            SysLog::Addlog('查看 ID 为'.$id.'的用户', $this->request, 0);
            return json(['valid'=>1,'msg'=>'删除用户成功']);
        }
    }

    public function add() {
        if($this->request->isPost()) {
            $res = (new \app\api\model\User())->reg(input('post.'));
            SysLog::Addlog('添加用户，id 为'.$res['id'], $this->request,0);
            $this->redirect('/user/'.$res['id']);
        }

        return $this->fetch('insert');
    }

    public function modify($id) {
        $user = Db::table('user')->where('id', $id)->find();
        if(!$user) {
            return json(['valid'=>0,'msg'=>'没有此用户']);
        }
        $this->assign('id', $id);
        $this->assign('user', $user);
        if($this->request->isPost()) {
            $data = input('post.');

            if(isset($data['password']))
                $data['password'] = md5('museum'.$data['password']);
            $res = Db::table('user')->where('id', $id)->update($data);
            if($res) {
                SysLog::Addlog('修改 ID 为'.$id.'的用户', $this->request, 0);
                $this->redirect('/user/'.$id);
            }
            else {
                SysLog::Addlog('修改 ID 为'.$id.'的用户', $this->request, 1);
                $this->error('修改失败');exit;
            }
        }

        return $this->fetch('modify');
    }

    public function ban($id) {
        if($this->request->isPost()) {
            $user = Db::table('user')->where('id', $id)->find();
            if(!$user) {
                return json(['valid'=>0,'msg'=>'没有此用户']);
            }
            $res = Db::table('user')->where('id', $id)->update(['status' => 1]);
            if(!$res) {
                SysLog::Addlog('禁止 ID 为'.$id.'的用户发表评论', $this->request, 1);
                return json(['valid'=>0,'msg'=>'修改失败']);
            }
            else {
                SysLog::Addlog('禁止 ID 为'.$id.'的用户发表评论', $this->request, 0);
                return json(['valid'=>1,'msg'=>'修改成功']);
            }
        }
    }

    public function cban($id) {
        if($this->request->isPost()) {
            $user = Db::table('user')->where('id', $id)->find();
            if(!$user) {
                return json(['valid'=>0,'msg'=>'没有此用户']);
            }
            $res = Db::table('user')->where('id', $id)->update(['status' => 0]);
            if(!$res) {
                SysLog::Addlog('取消禁止 ID 为'.$id.'的用户发表评论', $this->request, 1);
                return json(['valid'=>0,'msg'=>'修改失败']);
            }
            else {
                SysLog::Addlog('取消禁止 ID 为'.$id.'的用户发表评论', $this->request, 0);
                return json(['valid'=>1,'msg'=>'修改成功']);
            }
        }
    }

}