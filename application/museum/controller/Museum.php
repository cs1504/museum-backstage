<?php

namespace app\museum\controller;


use app\common\controller\CommonController;
use app\common\SysLog;
use think\Db;

class Museum extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $data = input('get.');
            $museum = \app\api\model\Museum::select();
            $this->assign('museum', $museum);
            SysLog::Addlog('查看博物馆总览', $this->request, 0);
            return $this->fetch('index');
        }

    }

    public function museum($id) {
        if($this->request->isGet()) {
            $museum = Db::table('museum')->where('id', $id)->find();
            $this->assign('museum', $museum);
            $this->assign('id', $id);
            SysLog::Addlog('查看 id 为'.$id.'的博物馆', $this->request, 0);
            return $this->fetch('view');
        }

        if($this->request->isDelete()) {
            $res = Db::table('museum')->where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此博物馆']);
            }
            $res = Db::table('museum')->delete($id);
            if(!$res) {
                SysLog::Addlog('删除 id 为'.$id.'的博物馆', $this->request, 1);
                return json(['valid'=>0,'msg'=>'删除失败']);
            }
            SysLog::Addlog('删除 id 为'.$id.'的博物馆', $this->request, 0);
            return json(['valid'=>1,'msg'=>'删除博物馆成功']);
        }
    }

    public function search() {
        if($this->request->isGet()) {
            $data = input('get.');
            if(!isset($data['name']))
                $this->redirect('/museum');
            if(!isset($data['page']))
                $data['page'] = 1;
            $this->assign('page', $data['page']);
            $count['museum'] = \app\api\model\Museum::where('name', 'like', '%'.$data['name'].'%')
                ->count();
            $pages = ceil($count['museum'] / 20);
            $this->assign('pages', $pages);
            $previous = $data['page'] - 1;
            $next = $data['page'] + 1;
            if($previous < 1)
                $previous = 1;
            if($next > $pages)
                $next = $pages;
            $this->assign('previous', $previous);
            $this->assign('next', $next);
            $this->assign('name', $data['name']);
            $museum = \app\api\model\Museum::where('name', 'like', '%'.$data['name'].'%')
                ->page($data['page'], 20)
                ->select();
            $this->assign('museum', $museum);

            return $this->fetch('search');
        }
    }

    public function insert() {
        if($this->request->isPost()) {
            $res = (new \app\api\model\Museum())->insert(input('post.'));
            SysLog::Addlog('添加新博物馆，id 为'.$res['id'], $this->request, 0);
            $this->redirect('/museum/'.$res['id']);
        }
        return $this->fetch('insert');
    }

    public function modify($id) {
        $museum = Db::table('museum')->where('id', '=', $id)->find();
        $this->assign('museum', $museum);
        $this->assign('id', $id);
        if($this->request->isPost()) {
            $date = input('post.');
            $res = Db::table('museum')->where('id', $id)
                ->update(['name' => $date['name'], 'introduce' => $date['introduce'], 'open_time' => $date['open_time'],
                    'edu_activity' => $date['edu_activity'], 'collection' => $date['collection'], 'academic' => $date['academic'],
                    'lng' => $date['lng'], 'lat' => $date['lat'], 'city' => $date['city']]);
            if($res) {
                SysLog::Addlog('修改 id 为'.$id.'的博物馆', $this->request, 0);
                $this->redirect('/museum/'.$id);
            }
            else {
                SysLog::Addlog('修改 id 为'.$id.'的博物馆', $this->request, 1);
                $this->error('修改失败');exit;
            }
        }
        return $this->fetch('modify');
    }

}