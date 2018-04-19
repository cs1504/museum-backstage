<?php

namespace app\api\controller;

use think\Controller;
use app\api\model\Exhibition;
use think\Db;

class ExhibitionControlApi extends Controller
{
    public function exhibition($id)
    {
        if($this->request->isGet()) {
            $exhibition = Db::table('exhibition')
                ->alias('e')
                ->where('e.museum_id', $id)
                ->join('museum m', 'e.museum_id = m.id')
                ->field('e.id, e.name as title, m.name as museum, e.museum_id, e.time, e.address, e.introduce')
                ->find();
            if(!$exhibition) {
                return json(['valid'=>0,'msg'=>'没有此展览']);
            }
            return json($exhibition);
        }
        if($this->request->isDelete()) {
            $res = Exhibition::where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此展览']);
            }
            $res = Db::table('exhibition')->delete($id);
            if(!$res)
                return json(['valid'=>0,'msg'=>'删除失败']);
            return json(['valid'=>1,'msg'=>'删除展览成功']);
        }

    }

    public function search()
    {
        if(request()->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
//            $exhibition = Db::table('exhibition')
//                ->alias('e')
//                ->where('e.name', 'like', '%'.$data['name'].'%')
//                ->join('museum m', 'e.museum_id = m.id')
//                ->page($data['page'], 10)
//                ->field('e.id, e.name, m.name as museum, m.id as museum_id, e.time, e.address, e.introduce')
//                ->select();
            $exhibition = Db::table('exhibition')
                ->alias('e')
                ->where('e.name', 'like', '%'.$data['name'].'%')
                ->join('museum m', 'e.museum_id = m.id')
                ->page($data['page'], 10)
                ->field('e.id, e.name as title, m.name as museum, e.museum_id, e.time, e.address, e.introduce')
                ->select();
            return json($exhibition);
        }
    }
}