<?php

namespace app\api\controller;

use app\api\model\Admin;
use app\api\common\AdminControlCommon;

class AdminInfoControlApi extends AdminControlCommon
{

    public function getAdminInfo() {
        if(request()->isPost()) {
            $admin = Admin::get(input('post.id'));
            return json($admin->hidden(['password'])->append(['roletext']));
        }
        else {
            return json(['valid' => 0, 'msg' => '请用 post 方法']);
        }
    }
}