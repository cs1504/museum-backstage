<?php

namespace app\api\controller;



use think\Controller;
use app\api\model\Exhibition;

class ExhibitionControlApi extends Controller
{
    public function exhibition($id)
    {
        if($this->request->isGet()) {
            $exhibition = Exhibition::where('id', $id)->find();
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
            $exhibition = Exhibition::where('name', 'like', '%'.$data['name'].'%')
                ->page($data['page'], 10)
                ->select();
            return json($exhibition);
        }
    }
}