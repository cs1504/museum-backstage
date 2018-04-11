<?php

namespace app\api\validate;

use think\Validate;

class UserUpdate extends Validate
{
    protected $rule = [
        'id'=>'require'
    ];
    protected $message = [
        'id.require'=>'请输入id'
    ];
}