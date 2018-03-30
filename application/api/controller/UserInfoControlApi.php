<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 30/03/2018
 * Time: 3:12 PM
 */

namespace app\api\controller;
use app\api\common\UserControlCommon;
use app\api\model\User;

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
}