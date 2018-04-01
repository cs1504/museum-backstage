<?php

namespace app\api\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'loginname'=>'require',
        'password'=>'require',
    ];
    protected $message = [
        'loginname.require'=>'请输入用户名',
        'password.require'=>'请输入密码',
    ];
}