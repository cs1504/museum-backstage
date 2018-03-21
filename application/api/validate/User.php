<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 21/03/2018
 * Time: 6:15 PM
 */

namespace app\api\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'loginname'=>'require',
        'password'=>'require',
    ];
    protected $message = [
        'user.require'=>'请输入用户名',
        'password.require'=>'请输入密码',
    ];
}