<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 08/04/2018
 * Time: 1:21 PM
 */

namespace app\museum\controller;

use app\common\controller\CommonController;
use app\common\SysLog;
use think\Db;

class Comments extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
            $this->assign('page', $data['page']);
            $count['comment'] = Db::table('comment')->where('museum_id', '<>', 'null')->count();
            $pages = ceil($count['comment'] / 10);
            $this->assign('pages', $pages);
            $previous = $data['page'] - 1;
            $next = $data['page'] + 1;
            if($previous < 1)
                $previous = 1;
            if($next > $pages)
                $next = $pages;
            $this->assign('previous', $previous);
            $this->assign('next', $next);
            $comment = Db::table('comment')
                ->alias('c')
                ->join('user u', 'c.user_id = u.id')
                ->join('museum m', 'c.museum_id = m.id')
                ->page($data['page'], 10)
                ->field('c.id, c.coption, nickname, m.name as museum_name, c.status, c.user_ip, c.time, c.content, c.parent, u.avatar')
                ->select();
//            dump($comment);
            $this->assign('comment', $comment);
            SysLog::Addlog('查看评论总览页面', $this->request, 0);
            return $this->fetch('index');
        }
    }
}