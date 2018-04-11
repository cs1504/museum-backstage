<?php

namespace app\api\controller;
use app\api\common\UserControlCommon;
use app\api\model\User;
use think\Db;

class UserInfoControlApi extends UserControlCommon
{
    public function getUserInfo() {
        if(request()->isPost()) {
            $user = User::get(input('post.id'));
            return json($user->hidden(['password'])->append(['statustext']));
        }
        else {
            return json(['valid' => 0, 'msg' => '请用 post 方法']);
        }
    }

    public function updateUserInfo() {
        if($this->request->isPost()) {
            $data = input('post.');
            $validate = new \app\api\validate\UserUpdate();
            //如果验证不通过
            if(!$validate->check($data)){
                return json(['valid'=>0,'msg'=>$validate->getError()]);
            }

            $user = Db::table('user')->where('id', $data['id'])->find();

            if(!$user)
                return json(['valid' => 0, 'msg' => '没有此用户']);

            $data['avatar'] = null;
            $pic = null;
            if(isset($_FILES['avatar']['tmp_name']))
                $pic = $_FILES['avatar']['tmp_name'];
            if($pic){
                // 上传的路径，建议写物理路径
                $uploadDir = 'static/upload/avatar';
                // 创建文件夹
                if(!file_exists($uploadDir)){
                    mkdir($uploadDir, 0777);
                }
                // 用时间戳来保存图片，防止重复
                $targetFile = $uploadDir . '/' . time() . $_FILES['avatar']['name'];
                // 将临时文件 移动到我们指定的路径，返回上传结果
                $upload_ret = move_uploaded_file($pic, $targetFile) ? true : false;
                if(!$upload_ret) {
                    return json(['valid' => 0, 'msg' => '图片上传失败']);
                }
                $data['avatar'] = $targetFile;
            }
            if(isset($data['password'])) {
                $data['password'] = md5('museum'.$data['password']);
            }
            $res = Db::table('user')->where('id', $data['id'])->update($data);
            if(!$res)
                return json(['valid' => 0, 'msg' => '更新失败']);
            return json(['valid' => 1, 'msg' => '更新成功']);
        }
    }
}