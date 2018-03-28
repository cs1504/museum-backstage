<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 26/03/2018
 * Time: 9:38 PM
 */

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
        return json($news);
    }

    public function search()
    {
        if (request()->isGet()) {
            $data = input('get.');
            $list = Jieba::cut($data["title"]);
            $q = '';
            foreach ($list as $ss) {
                if (strlen($ss) > 1) {
                    $q .= str_replace('%','',urlencode($ss)) . ' ';
                }
            }
            $news = Db::query("select id, title, author, release_time, modify_time, excerpt, content, status, nature from news where MATCH (titleindex,excerptindex,contentindex) AGAINST ('+".$q."')");
            return json($news);
        }
    }
    public function insert() {
        if (request()->isPost()) {
            $data = input('post.');
            $data['titleindex'] = implode('', cut($data['title']));
            var_dump($data['titleindex']);
            $res = (new News())->insert($data);
            return json($res);
        }
    }
}