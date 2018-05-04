<?php

namespace app\common;

use think\Loader;
Loader::import('aliyuncs.aliyun-php-sdk-core.Config');
use Green\Request\V20170825 as Green;
date_default_timezone_set("PRC");
use think\Db;

class AudioCheck
{
    public function request() {
        
    }
}