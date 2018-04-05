<?php

namespace app\api\controller;

use think\Controller;
use app\api\model\Museum;


class MuseumControlApi extends Controller
{
    public function museum($id)
    {
        if($this->request->isGet()) {
            $museum = Museum::where('id', $id)->find();
            if(!$museum) {
                return json(['valid'=>0,'msg'=>'没有此博物馆']);
            }
            return json($museum);
        }
        if($this->request->isDelete()) {
            $res = Museum::where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此博物馆']);
            }
            $res = Db::table('museum')->delete($id);
            if(!$res)
                return json(['valid'=>0,'msg'=>'删除失败']);
            return json(['valid'=>1,'msg'=>'删除博物馆成功']);
        }
    }

    public function search()
    {
        if(request()->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
            $museum = Museum::where('name', 'like', '%'.$data['name'].'%')
                ->page($data['page'], 10)
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

    public function insert() {
        if(request()->isPost()) {
            $res = (new Museum())->insert(input('post.'));
            return json($res);
        }
    }
}