<?php

namespace app\common;

use think\Db;
use think\Session;

class SysLog
{
    public static function Addlog($description, $request, $status = 0, $operator = null) {
        if($operator == null) {
            $operator = Session::get('id') == null ? 0 : Session::get('id');
        }
        Db::table('logs')->insert([
            'operator' => $operator,
            'url' => $request->url(true),
            'description' => $description,
            'ip' => $request->ip(),
            'status' => $status]);
    }
}