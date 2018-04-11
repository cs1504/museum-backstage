<?php

namespace app\api\validate;


use think\Validate;

class CommentsAndStar extends Validate
{
    protected $rule = [
        'coption'=>'require',
        'user_id'=>'require',
        'content'=>'require|min:10|max:140',
        'museum_id'=>'require',
        'exhibition_star'=>'require|number|between:1,5',
        'service_star'=>'require|number|between:1,5',
        'environment_star'=>'require|number|between:1,5',
    ];
    protected $message = [
        'coption.require'=>'未设定评论种类',
        'user_id.require'=>'请提交用户id',
        'content.require'=>'请输入10-140字评论',
        'content.min'=>'评论最少10个字',
        'content.max'=>'评论最多140个字',
        'museum_id.require' => '请输入博物馆id',
        'exhibition_star.require' => '请输入展览打分',
        'exhibition_star.number' => '输入必须是数字',
        'exhibition_star.between' => '打分只能在1-5之间',
        'service_star.require' => '请输入服务打分',
        'service_star.number' => '输入必须是数字',
        'service_star.between' => '打分只能在1-5之间',
        'environment_star.require' => '请输入环境打分',
        'environment_star.number' => '输入必须是数字',
        'environment_star.between' => '打分只能在1-5之间',
    ];
}