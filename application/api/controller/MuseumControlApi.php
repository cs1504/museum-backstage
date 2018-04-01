<?php

namespace app\api\controller;

use think\Controller;
use app\api\model\Museum;


class MuseumControlApi extends Controller
{
    public function museum($id)
    {
        $museum = Museum::where('id', $id)->find();
        return json($museum);
    }

    public function search()
    {
        if(request()->isGet()) {
            $data = input('get.');
            $museum = Museum::where('name', 'like', '%'.$data['name'].'%')
                ->select();
            return json($museum);
        }
    }

    public function nearest(){
        if(request()->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 0;
            $museum = Museum::where('lng', '>', 0)
                ->field('id, name, introduce, open_time, edu_activity, collection, academic, lng, lat, city')
                ->field('pow((lng-'.$data['lng'].'),2)+pow((lat-'.$data['lat'].'),2) as distance')
                ->order('distance')
                ->page($data['page'],10)
                ->select();
            return json($museum);
        }
    }

}