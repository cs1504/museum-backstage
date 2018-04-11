<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 04/04/2018
 * Time: 3:02 PM
 */

namespace app\api\validate;


use think\Validate;

class Museum extends Validate
{
    protected $rule = [
        'name'=>'require',
        'introduce'=>'require',
        'open_time'=>'require',
        'edu_activity'=>'require',
        'collection'=>'require',
        'academic'=>'require',
        'lng'=>'require',
        'lat'=>'require',
        'city'=>'require',

    ];
    protected $message = [
        'name.require'=>'请输入博物馆名称',
        'introduce.require'=>'请输入基本介绍',
        'open_time.require'=>'请输入开放时间',
        'edu_activity.require'=>'请输入教育活动',
        'collection.require'=>'请输入经典藏品信息',
        'academic.require'=>'请输入学术研究信息',
        'lng.require'=>'请输入经度',
        'lat.require'=>'请输入纬度',
        'city.require'=>'请输入省份',
    ];
}