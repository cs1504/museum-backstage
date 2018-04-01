<?php

namespace app\api\controller;



use think\Controller;
use app\api\model\Exhibition;

class ExhibitionControlApi extends Controller
{
    public function exhibition($id)
    {
        $exhibition = Exhibition::where('id', $id)->find();
        return json($exhibition);
    }

    public function search()
    {
        if(request()->isGet()) {
            $data = input('get.');
            $exhibition = Exhibition::where('name', 'like', '%'.$data['name'].'%')
                ->select();
            return json($exhibition);
        }
    }
}