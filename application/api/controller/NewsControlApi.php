<?php

namespace app\api\controller;


use think\Controller;
use app\api\model\News;
use think\Db;

ini_set('memory_limit', '1024M');
use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
Jieba::init();
Finalseg::init();

class NewsControlApi extends Controller
{
    public function news($id)
    {
        $news = News::where('id', $id)->find();
        if(!$news) {
            return json(['valid' => 0, 'msg' => '没有此新闻']);
        }
        return json($news);
    }

    public function search()
    {
        if (request()->isGet()) {
            $data = input('get.');
            if(isset($data['title'])) {
                $list = Jieba::cut($data["title"]);
                $q = '';
                foreach ($list as $ss) {
                    if (strlen($ss) > 1) {
                        $q .= str_replace('%','',urlencode($ss)) . ' ';
                    }
                }
                if(!isset($data['page']))
                    $data['page'] = 1;
                $data['page'] = ($data['page']-1) * 10;
                $news = Db::query("select id, title, author, release_time, modify_time, excerpt, content, status, nature from news where MATCH (titleindex) AGAINST ('+".$q." IN BOOLEAN MODE') limit ".$data['page']." , 10");
            }
            else if(isset($data['key'])) {
                $list = Jieba::cut($data["key"]);
                $q = '';
                foreach ($list as $ss) {
                    if (strlen($ss) > 1) {
                        $q .= str_replace('%','',urlencode($ss)) . ' ';
                    }
                }
                if(!isset($data['page']))
                    $data['page'] = 1;
                $data['page'] = ($data['page']-1) * 10;
                $news = Db::query("select id, title, author, release_time, modify_time, excerpt, content, status, nature from news where MATCH (titleindex,excerptindex,contentindex) AGAINST ('+".$q."') limit ".$data['page']." , 10");
            }
            else {
                if(!isset($data['page']))
                    $data['page'] = 0;
                $news = Db::table('news')
                    ->field('id, title, author, release_time, modify_time, excerpt, content, status, nature')
                    ->page($data['page'],10)->select();
            }
            if(!$news) {
                return json(['valid' => 0, 'msg' => '查找不到相关新闻']);
            }
            return json($news);
        }
    }

    public function latest() {
        if(request()->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 0;
            $news = Db::table('news')
                ->field('id, title, author, release_time, modify_time, excerpt, content, status, nature')
                ->order('release_time desc')
                ->page($data['page'],10)
                ->select();
            if(!$news) {
                return ['valid' => 0, 'msg' => '可能被删库了！！！'];
            }
            return json($news);
        }

    }

    public function insert() {
        if (request()->isPost()) {
            $data = input('post.');
            $res = (new News())->insert($data);
            return json($res);
        }
    }
}