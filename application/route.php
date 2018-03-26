<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use \think\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('api/museum/:id','api/MuseumControlApi/museum');
Route::get('api/museum/search','api/MuseumControlApi/search');
Route::any('api/admin/login/','api/AdminControlApi/login');
Route::any('api/user/login/','api/UserControlApi/login');

Route::get('api/news/:id','api/NewsControlApi/news');
Route::get('api/news/search','api/NewsControlApi/search');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
