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


class News extends CommonController
{
    public function index() {
        if($this->request->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
            $this->assign('page', $data['page']);
            $count['news'] = Db::table('news')->count();
            $pages = ceil($count['news'] / 10);
            $this->assign('pages', $pages);
            $previous = $data['page'] - 1;
            $next = $data['page'] + 1;
            if($previous < 1)
                $previous = 1;
            if($next > $pages)
                $next = $pages;
            $this->assign('previous', $previous);
            $this->assign('next', $next);
            $news = \app\api\model\News::page($data['page'], 10)->select();
            $this->assign('news', $news);
            return $this->fetch('index');
        }
    }

    public function news($id) {
        if($this->request->isGet()) {
            $news = Db::table('news')->where('id', $id)->find();
            $this->assign('news', $news);
            $this->assign('id', $id);
            return $this->fetch('view');
        }

        if($this->request->isDelete()) {

        }
    }

    public function search() {
        if($this->request->isGet()) {

        }
    }

    public function insert() {
        if($this->request->isPost()) {

        }
    }

    public function modify() {
        if($this->request->isPost()) {

        }
    }
}