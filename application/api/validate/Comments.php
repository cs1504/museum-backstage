<?php

namespace app\api\validate;


use think\Validate;

class Comments extends Validate
{
    protected $rule = [
        'coption'=>'require',
        'user_id'=>'require',
        'content'=>'require|min:10|max:140',
    ];
    protected $message = [
        'coption.require'=>'未设定评论种类',
        'user_id.require'=>'请提交用户id',
        'content.require'=>'请输入10-140字评论',
        'content.min'=>'评论最少10个字',
        'content.max'=>'评论最多140个字',
    ];
}