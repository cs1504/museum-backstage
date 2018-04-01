<?php

namespace app\api\controller;


use app\api\model\Audio;
use think\Controller;
use think\Db;

class AudioControlApi extends Controller
{
    public function audio($id)
    {
        $audio = Audio::where('id', $id)->find();
        return json($audio);
    }

    public function user($userid) {
        $audio = Audio::Where('user_id', $userid)->find();
        return json($audio);
    }

    public function search()
    {
        if (request()->isGet()) {
            $data = input('get.');
            $audio = Audio::where('description', 'like', '%' . $data['description'] . '%')
                ->select();
            return json($audio);
        }
    }

    public function add() {
        if(request()->isPost()) {
            $data = input('post.');
            //1.执行验证
            $validate = new \app\api\validate\Audio;
            //如果验证不通过
            if(!$validate->check($data)){
                return json(['valid'=>0,'msg'=>$validate->getError()]);
            }
            $res = Db::name('audio')->insert($data);
            $id = Db::name('audio')->getLastInsID();
            if(!$res) {
                //说明在数据库未匹配到相关数据
                return json(['valid' => 0, 'msg' => '添加失败，未知原因']);
            }
            return json(['valid'=>1,'id' => $id, 'user_id' => $data['user_id'], 'museum_id' => $data['museum_id'], 'msg'=>'添加成功']);
        }
    }
}