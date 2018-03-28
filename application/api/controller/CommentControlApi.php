<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 28/03/2018
 * Time: 3:25 PM
 */

namespace app\api\controller;


use think\Controller;
use app\api\model\Comment;
use think\Db;

class CommentControlApi extends Controller
{
    public function comments() {
        if(request()->isPost()) {
            $data = input('post.');

            //1.执行验证
            $validate = new \app\api\validate\Comments;
            //如果验证不通过
            if(!$validate->check($data)){
                return json(['valid'=>0,'msg'=>$validate->getError()]);
            }

            switch ($data['coption']) {
                case 1:
                    if(!isset($data['museum_id']))
                        return json(['valid'=>0,'msg'=>'请关联对应的博物馆']);
                    $res = Db::name('museum')
                        ->where('id', $data['museum_id'])
                        ->find();
                    if(!$res)
                        return json(['valid'=>0,'msg'=>'没有此博物馆']);
                    break;
                case 2:
                    if(!isset($data['exhibition_id']))
                        return json(['valid'=>0,'msg'=>'请关news联对应的展览']);
                    $res = Db::name('exhibition')
                        ->where('id', $data['exhibition_id'])
                        ->find();
                    if(!$res)
                        return json(['valid'=>0,'msg'=>'没有此展览']);
                    break;
                case 3:
                    if(!isset($data['news_id']))
                        return json(['valid'=>0,'msg'=>'请关联对应的博物馆']);
                    $res = Db::name('news')
                        ->where('id', $data['news_id'])
                        ->find();
                    if(!$res)
                        return json(['valid'=>0,'msg'=>'没有此新闻']);
                    break;
                case 4:
                    if(!isset($data['audio_id']))
                        return json(['valid'=>0,'msg'=>'请关联对应的展览']);
                    $res = Db::name('audio')
                        ->where('id', $data['audio_id'])
                        ->find();
                    if(!$res)
                        return json(['valid'=>0,'msg'=>'没有此音频讲解']);
                    break;
                default:
                    return json(['valid'=>0,'msg'=>'非法评论']);
                    break;
            }
            $data['user_ip'] = request()->ip();
            $res = Db::name('comment')->insert($data);
            if(!$res) {
                return json(['valid'=>0,'msg'=>'评论失败']);
            }
            $id = Db::name('user')->getLastInsID();
            return json(['valid'=>1, 'id' => $id, 'msg'=>'评论成功']);
        }
    }
    public function comment($id) {
        if(request()->isPost()) {
            return json(['valid'=>0,'msg'=>'非法访问']);
        }
        if(request()->isGet()) {
            $res = Comment::where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此评论']);
            }
            return json($res);
        }
        if(request()->isPut()) {
            $data = input('put.');
            //1.执行验证
            $validate = new \app\api\validate\Comment;
            //如果验证不通过
            if(!$validate->check($data)){
                return json(['valid'=>0,'msg'=>$validate->getError()]);
            }
            $res = Comment::where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此评论']);
            }
            $res = false;
            if(isset($data['content'])) {
                dump(input('content'));
                $res = Db::table('comment')
                    ->update(['content' => $data['content'], 'id'=>$id]);
                if(!$res)
                    return json(['valid'=>0,'msg'=>'修改评论内容失败']);
            }
            if(isset($data['status'])) {
                $res = Db::table('comment')
                    ->update(['status' => $data['status'], 'id'=>$id]);
                if(!$res)
                    return json(['valid'=>0,'msg'=>'修改评论状态失败']);
            }
            if(request()->ip()) {
                Db::table('comment')
                    ->update(['user_ip' => request()->ip(), 'id'=>$id]);
            }
            if(!$res)
                return json(['valid'=>0,'msg'=>'未发送数据']);
            return json(['valid'=>1,'msg'=>'修改评论成功']);
        }
    }

}