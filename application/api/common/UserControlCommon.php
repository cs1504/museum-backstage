<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 30/03/2018
 * Time: 3:12 PM
 */

namespace app\api\common;
use think\Controller;
use think\Request;
use think\Session;

class UserControlCommon extends Controller
{
    public function __construct(Request $request = null) {

        parent::__construct($request);
        if(!Session::has('loginname')) {
            $this->redirect('api/user/failed');
        }
    }
}