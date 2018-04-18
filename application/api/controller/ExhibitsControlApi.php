<?php

namespace app\api\controller;


use think\Controller;
use think\Db;

class ExhibitsControlApi extends Controller
{
    public function exhibits($id)
    {
        if($this->request->isGet()) {
            $exhibits = Db::table('exhibits')->where('museum_id', $id)->select();
            if(!$exhibits) {
                return json(['valid'=>0,'msg'=>'没有此展品']);
            }
            return json($exhibits);
        }
        if($this->request->isDelete()) {
            $res = Db::table('exhibits')->where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此展品']);
            }
            $res = Db::table('exhibits')->delete($id);
            if(!$res)
                return json(['valid'=>0,'msg'=>'删除失败']);
            return json(['valid'=>1,'msg'=>'删除展品成功']);
        }

    }

    public function search()
    {
        if(request()->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
            $exhibits = Db::table('exhibits')
                ->alias('e')
                ->where('e.name', 'like', '%'.$data['name'].'%')
                ->join('museum m', 'e.museum_id = m.id')
                ->page($data['page'], 10)
                ->field('e.id, e.name, m.name as museum, m.id as museum_id, e.introduce')
                ->select();
            return json($exhibits);
        }
    }
}