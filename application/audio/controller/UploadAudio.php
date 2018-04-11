<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 05/04/2018
 * Time: 12:20 PM
 */

namespace app\audio\controller;


use app\common\controller\CommonController;

class UploadAudio extends CommonController
{
    public function index() {
        $token = \app\api\controller\QiniuToken::getToken();
        $this->assign('token', $token);
        return $this->fetch('index');
    }
}