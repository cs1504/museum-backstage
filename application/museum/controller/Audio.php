<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 06/04/2018
 * Time: 12:24 AM
 */

namespace app\museum\controller;

use app\common\controller\CommonController;
use think\Db;

class Audio extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
            $this->assign('page', $data['page']);
            $count['audio'] = Db::table('audio')->count();
            $pages = ceil($count['audio'] / 10);
            $this->assign('pages', $pages);
            $previous = $data['page'] - 1;
            $next = $data['page'] + 1;
            if($previous < 1)
                $previous = 1;
            if($next > $pages)
                $next = $pages;
            $this->assign('previous', $previous);
            $this->assign('next', $next);
            $audio = Db::table('audio')
                ->alias('a')
                ->join('user u', 'a.user_id = u.id')
                ->join('museum m', 'a.museum_id = m.id')
                ->page($data['page'], 10)
                ->field('audio.id, loginname as user_name, name as museum_name, audio.status, upload_time, 
                pass_time, addr, description')
                ->select();
//            dump($audio);
            $this->assign('audio', $audio);
            return $this->fetch('index');
        }
    }

    public function audio($id) {
        if($this->request->isGet()) {
            $audio = Db::table('audio')->where('id', $id)->find();
            $this->assign('museum', $audio);
            $this->assign('id', $id);
            return $this->fetch('view');
        }

        if($this->request->isDelete()) {
            $res = Db::table('audio')->where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此音频']);
            }
            $res = Db::table('audio')->delete($id);
            if(!$res)
                return json(['valid'=>0,'msg'=>'删除失败']);
            return json(['valid'=>1,'msg'=>'删除音频成功']);
        }
    }

    public function add() {
        if($this->request->isPost()) {
            $res = (new \app\api\model\Audio())->insert(input('post.'));
            $this->redirect('/audio/'.$res['id']);
        }
        return $this->fetch('insert');
    }

}