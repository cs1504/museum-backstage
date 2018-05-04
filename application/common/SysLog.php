<?php

namespace app\common;

use think\Db;
use think\Session;

class SysLog
{
    public static function Addlog($description, $request, $status = 0) {
        Db::table('logs')->insert([
            'operator' => Session::get('id') == null ? 0 : Session::get('id'),
            'url' => $request->url(true),
            'description' => $description,
            'ip' => $request->ip(),
            'status' => $status]);
    }
}