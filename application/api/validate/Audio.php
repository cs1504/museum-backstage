<?php

namespace app\api\validate;


use think\Validate;

class Audio extends Validate
{
    protected $rule = [
        'user_id'=>'require',
        'museum_id'=>'require',
        'addr'=>'require|url',
        'description'=>'require',
    ];
    protected $message = [
        'user_id.require'=>'请提交用户ID',
        'museum_id.require'=>'请提交博物馆ID',
        'addr.require'=>'请提交 url',
        'addr.url'=>'请确认提交的是 url',
        'description.require'=>'请提交描述',
    ];
}