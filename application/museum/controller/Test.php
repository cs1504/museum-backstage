<?php

namespace app\museum\controller;


use app\common\AudioCheck;
use app\common\controller\CommonController;

class Test extends CommonController
{
    public function index() {
        $checkaudio = new AudioCheck();
//        $checkres = $checkaudio->request('http://p6m0gir2c.bkt.clouddn.com/%E9%81%93%E5%BE%B7%E7%BB%8F60b.mp3');
//        $checkres = $checkaudio->request('');
        $checkres = $checkaudio->response('vc_f_58ILGvrTrFw5kqIo9lsJnm-1oOWoB', '5aed3563a5443');
//        dump(($checkres));
        print_r($checkres['content']);
    }
}

//object(stdClass)#1257 (5) {
//["code"] => int(200)
//["dataId"] => string(13) "5aed03304a4f9"
//["msg"] => string(2) "OK"
//["taskId"] => string(34) "vc_f_2seP6x$FAcY7CAL@3fePiQ-1oOTkt"
//["url"] => string(67) "http://p6m0gir2c.bkt.clouddn.com/%E9%81%93%E5%BE%B7%E7%BB%8F60b.mp3"
//}