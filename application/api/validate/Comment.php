<?php

namespace app\api\validate;


use think\Validate;

class Comment extends Validate
{
    protected $rule = [
        'content'=>'require|min:10|max:140',
    ];
    protected $message = [
        'content.require'=>'请输入10-140字评论',
        'content.min'=>'评论最少10个字',
        'content.max'=>'评论最多140个字',
    ];
}