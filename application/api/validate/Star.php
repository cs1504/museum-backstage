<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 06/04/2018
 * Time: 3:15 PM
 */

namespace app\api\validate;


use think\Validate;

class Star extends Validate
{
    protected $rule = [
        'user_id'=>'require',
        'museum_id'=>'require',
        'exhibition_star'=>'number|between:1,5',
        'service_star'=>'number|between:1,5',
        'environment_star'=>'number|between:1,5',
    ];
    protected $message = [
        'user_id.require'=>'请输入用户id',
        '',
    ];
}