<?php

namespace app\api\common;

use think\Controller;
use think\Request;
use think\Session;

class AdminControlCommon extends Controller
{
    public function __construct(Request $request = null) {

        parent::__construct($request);
        if(!Session::has('loginname')) {
            $this->redirect('api/admin/failed');
        }
    }
}