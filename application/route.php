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


Route::any('login', 'admin/Login/login');
Route::any('logout', 'admin/Login/logout');

Route::any('museum/modify/:id', 'museum/Museum/modify');
Route::any('museum/:id', 'museum/Museum/museum');
Route::any('museum', 'museum/Museum/index');
Route::any('museum/search', 'museum/Museum/search');
Route::any('museum/insert', 'museum/Museum/insert');


Route::any('news/modify/:id', 'museum/News/modify');
Route::any('news/:id', 'museum/News/news');
Route::any('news', 'museum/News/index');
Route::any('news/search', 'museum/News/search');
Route::any('news/insert', 'museum/News/insert');

Route::any('exhibition/modify/:id', 'museum/Exhibition/modify');
Route::any('exhibition/:id', 'museum/Exhibition/exhibition');
Route::any('exhibition', 'museum/Exhibition/index');
Route::any('exhibition/search', 'museum/Exhibition/search');
Route::any('exhibition/insert', 'museum/Exhibition/insert');


Route::any('audio/modify/:id', 'museum/Audio/modify');
Route::any('audio/:id', 'museum/Audio/news');
Route::any('audio', 'museum/Audio/index');
Route::any('audio/search', 'museum/Audio/search');
Route::any('audio/add', 'museum/Audio/add');

Route::any('user/ban/:id', 'museum/User/ban');
Route::any('user/cban/:id', 'museum/User/cban');
Route::any('user/modify/:id', 'museum/User/modify');
Route::any('user/:id', 'museum/User/user');
Route::any('user', 'museum/User/index');
Route::any('user/add', 'museum/User/add');

Route::any('comments', 'museum/Comments/index');


Route::any('admin/modify/:id', 'museum/Admin/modify');
Route::any('admin/:id', 'museum/Admin/admin');
Route::any('admin', 'museum/Admin/index');
Route::any('admin/add', 'museum/Admin/add');


Route::any('setting', 'museum/System/setting');





Route::any('api/museum/:id','api/MuseumControlApi/museum');
Route::get('api/museum/search/','api/MuseumControlApi/search');
Route::get('api/museum/nearest/','api/MuseumControlApi/nearest');
Route::post('api/museum/insert/','api/MuseumControlApi/insert');

Route::any('api/exhibition/:id','api/ExhibitionControlApi/exhibition');
Route::get('api/exhibition/search/','api/ExhibitionControlApi/search');

Route::any('api/exhibits/:id','api/ExhibitsControlApi/exhibits');
Route::get('api/exhibits/search/','api/ExhibitsControlApi/search');

Route::any('api/admin/login/','api/AdminControlApi/login');
Route::any('api/admin/reg/','api/AdminControlApi/reg');
Route::any('api/admin/logout/','api/AdminControlApi/logout');
Route::any('api/admin/failed', 'api/AdminControlApi/failed');
Route::any('api/admin/getinfo/','api/AdminInfoControlApi/getAdminInfo');

Route::any('api/user/login/','api/UserControlApi/login');
Route::any('api/user/reg/','api/UserControlApi/reg');
Route::any('api/user/logout/','api/UserControlApi/logout');
Route::any('api/user/failed', 'api/UserControlApi/failed');
Route::any('api/user/getinfo/','api/UserInfoControlApi/getUserInfo');
Route::any('api/user/updateinfo/','api/UserInfoControlApi/updateUserInfo');


//Route::get('api/news/:id','api/NewsControlApi/news');
Route::get('api/news/search','api/NewsControlApi/search');
Route::get('api/news/latest', 'api/NewsControlApi/latest');
Route::post('api/news/insert', 'api/NewsControlApi/insert');

Route::any('api/audio/:id', 'api/AudioControlApi/audio');
Route::get('api/audiobyuser/:userid', 'api/AudioControlApi/user');
Route::get('api/audio/search/', 'api/AudioControlApi/search');
Route::post('api/audio/add/', 'api/AudioControlApi/add');

Route::get('api/comments/museum/:id', 'api/CommentControlApi/museumcomments');
Route::get('api/comments/exhibition/:id', 'api/CommentControlApi/exhibitioncomments');
Route::get('api/comments/news/:id', 'api/CommentControlApi/newscomments');
Route::get('api/comments/audio/:id', 'api/CommentControlApi/audiocomments');
Route::any('api/commentandstar', 'api/CommentControlApi/commentandstar');
Route::any('api/getcommentandstar/:id', 'api/CommentControlApi/getcommentandstar');
Route::any('api/getcommentandstar', 'api/CommentControlApi/getcommentandstar');
Route::any('api/comments/:id', 'api/CommentControlApi/comments');
Route::any('api/comments', 'api/CommentControlApi/comments');

Route::any('api/star', 'api/StarControlApi/star');
Route::any('api/getstar/:id', 'api/StarControlApi/getstar');


Route::any('api/getqiniutoken', 'api/QiniuToken/getToken');










return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
