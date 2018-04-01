<?php

namespace app\api\controller;


use think\Controller;
use Qiniu\Auth;
use think\Db;


class QiniuToken extends Controller
{
    public function getToken() {
        if(request()->isPost()) {
            $accessKey = Db::table('options')->where('option_name', '=', 'AK')->value('option_value');
            $secretKey = Db::table('options')->where('option_name', '=', 'SK')->value('option_value');
            $auth = new Auth($accessKey, $secretKey);
            $bucket = Db::table('options')->where('option_name', '=', 'bucket')->value('option_value');
            // 生成上传Token
            $token = $auth->uploadToken($bucket);
            return json(['valid' => '1', 'msg' => 'token获取成功', 'token' => $token]);
        }
    }
}