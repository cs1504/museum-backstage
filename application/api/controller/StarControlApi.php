<?php

namespace app\api\controller;


use think\Db;

class StarControlApi
{
    public function star() {
        if(request()->isPost()) {
            $data = input('post.');
            //1.执行验证
            $validate = new \app\api\validate\Star;
            //如果验证不通过
            if(!$validate->check($data)){
                return json(['valid'=>0,'msg'=>$validate->getError()]);
            }

            $res = Db::name('star')->insert($data);
            if(!$res) {
                //说明在数据库未匹配到相关数据
                return json(['valid' => 0, 'msg' => '打分失败，未知原因']);
            }
            return json(['valid'=>1,'user_id' => $data['user_id'],
                'museum_id' => $data['museum_id'],'msg'=>'打分成功']);
        }
        else {
            return json(['valid' => 0, 'msg' => '请用 post 方法']);
        }
    }

    public function getstar($id) {
        if(request()->isGet()) {
            $data = input('get.');
            if(isset($data['user_id'])) {
                $exhibition_star = Db::table('star')
                    ->where('museum_id', $id)
                    ->where('user_id', $data['user_id'])
                    ->value('exhibition_star');
                $service_star = Db::table('star')
                    ->where('museum_id', $id)
                    ->where('user_id', $data['user_id'])
                    ->value('service_star');
                $environment_star = Db::table('star')
                    ->where('museum_id', $id)
                    ->where('user_id', $data['user_id'])
                    ->value('environment_star');
            }
            else {
                $exhibition_star = Db::table('star')
                    ->where('museum_id', $id)
                    ->avg('exhibition_star');
                $service_star = Db::table('star')
                    ->where('museum_id', $id)
                    ->avg('service_star');
                $environment_star = Db::table('star')
                    ->where('museum_id', $id)
                    ->avg('environment_star');
            }
            $avg = round((($environment_star+$service_star+$environment_star)/3)*2, 1);
            $comment_count = Db::table('comment')
                ->where('museum_id', $id)
                ->count();
            return json([
                'isuser' => isset($data['user_id']),
                'exhibition_star' => $exhibition_star,
                'service_star' => $service_star,
                'environment_star' => $environment_star,
                'avg' => $avg,
                'comment_count' => $comment_count
                ]);
        }
    }
}