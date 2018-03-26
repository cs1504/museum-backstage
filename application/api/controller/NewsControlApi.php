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
            $news = News::where('title', 'like', '%' . $data['title'] . '%')
                ->select();
            return json($news);
        }
    }
}