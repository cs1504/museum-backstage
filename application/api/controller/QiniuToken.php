<?php

namespace app\api\controller;


use think\Controller;
use Qiniu\Auth;
use think\Db;


class QiniuToken extends Controller
{
    public static function getToken() {
        $accessKey = Db::table('options')->where('option_name', '=', 'AK')->value('option_value');
        $secretKey = Db::table('options')->where('option_name', '=', 'SK')->value('option_value');
        $auth = new Auth($accessKey, $secretKey);
        $bucket = Db::table('options')->where('option_name', '=', 'bucket')->value('option_value');
        $url_pre = Db::table('options')->where('option_name', '=', 'url_pre')->value('option_value');
        // 生成上传Token
        $expires = 3600;
        $policy = null;
        $token = $auth->uploadToken($bucket, null, $expires, $policy, true);
        if(request()->isPost()) {
            return json(['valid' => '1', 'msg' => 'token获取成功', 'token' => $token, 'url_pre' => $url_pre]);
        }
        return $token;
    }
}