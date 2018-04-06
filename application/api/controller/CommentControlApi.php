<?php

namespace app\api\controller;


use think\Controller;
use app\api\model\Comment;
use think\Db;

class CommentControlApi extends Controller
{
    public function comments($id=0) {
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
            $id = Db::name('comment')->getLastInsID();
            return json(['valid'=>1, 'id' => $id, 'msg'=>'评论成功']);
        }
        if(request()->isGet()) {
            if($id == 0) {
//                $res
            }
            else {
                $res = Comment::where('id', $id)
                    ->find();
                if(!$res) {
                    return json(['valid'=>0,'msg'=>'没有此评论']);
                }
                return json($res);
            }
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
        if(request()->isDelete()) {
            $res = Comment::where('id', $id)
                ->find();
            if(!$res) {
                return json(['valid'=>0,'msg'=>'没有此评论']);
            }
            $res = Db::table('comment')->delete($id);
            if(!$res)
                return json(['valid'=>0,'msg'=>'删除失败']);
            return json(['valid'=>1,'msg'=>'删除评论成功']);
        }

    }

    public function museumcomments($id) {
        if(request()->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
            $res = Db::table('comment')
                ->alias('c')
                ->where('coption', '=', 1)
                ->where('museum_id', '=', $id)
                ->join('user u', 'c.user_id = u.id')
                ->join('museum m', 'c.museum_id = m.id')
                ->field('comment.id, coption, museum_id, name as museum_name, 
                user_id, loginname, nickname, user_ip, time, content, comment.status, parent')
                ->page($data['page'], 10)
                ->select();
            return json($res);
        }
    }

    public function exhibitioncomments($id) {
        if(request()->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
            $res = Db::table('comment')
                ->where('coption', '=', 2)
                ->where('exhibition_id', '=', $id)
                ->join('user u', 'c.user_id = u.id')
                ->join('exhibition e', 'c.exhibition_id = e.id')
                ->field('comment.id, coption, exhibition_id, name as exhibition_name, 
                user_id, loginname, nickname, user_ip, time, content, comment.status, parent')
                ->page($data['page'], 10)
                ->select();
            return json($res);
        }
    }

    public function newscomments($id) {
        if(request()->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
            $res = Db::table('comment')
                ->where('coption', '=', 3)
                ->where('news_id', '=', $id)
                ->page($data['page'], 10)
                ->select();
            return json($res);
        }
    }

    public function audiocomments($id) {
        if(request()->isGet()) {
            $data = input('get.');
            if(!isset($data['page']))
                $data['page'] = 1;
            $res = Db::table('comment')
                ->where('coption', '=', 4)
                ->where('audio_id', '=', $id)
                ->page($data['page'], 10)
                ->select();
            return json($res);
        }
    }
}