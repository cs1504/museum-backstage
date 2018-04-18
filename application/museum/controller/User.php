<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 08/04/2018
 * Time: 1:04 PM
 */

namespace app\museum\controller;

use app\common\controller\CommonController;
use think\Db;

class User extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $user = \app\api\model\User::select();
            $this->assign('user', $user);
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
            return $this->fetch('view');
        }

        if($this->request->isDelete()) {
            $user = Db::table('user')->where('id', $id)->find();
            if(!$user) {
                return json(['valid'=>0,'msg'=>'没有此用户']);
            }
            $res = Db::table('user')->where('id', $id)->delete();
            if(!$res)
                return json(['valid'=>0,'msg'=>'删除失败']);
            return json(['valid'=>1,'msg'=>'删除用户成功']);
        }
    }

    public function add() {
        if($this->request->isPost()) {
            $res = (new \app\api\model\User())->reg(input('post.'));
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
            if($res)
                $this->redirect('/user/'.$id);
            else
                $this->error('修改失败');exit;
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
            if(!$res)
                return json(['valid'=>0,'msg'=>'修改失败']);
            else
                return json(['valid'=>1,'msg'=>'修改成功']);
        }
    }

    public function cban($id) {
        if($this->request->isPost()) {
            $user = Db::table('user')->where('id', $id)->find();
            if(!$user) {
                return json(['valid'=>0,'msg'=>'没有此用户']);
            }
            $res = Db::table('user')->where('id', $id)->update(['status' => 0]);
            if(!$res)
                return json(['valid'=>0,'msg'=>'修改失败']);
            else
                return json(['valid'=>1,'msg'=>'修改成功']);
        }
    }

}