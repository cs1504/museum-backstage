<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 01/04/2018
 * Time: 6:53 PM
 */

namespace app\common\controller;


use think\Controller;
use think\Db;
use think\Session;
use app\api\model\Admin;
use think\Request;

class CommonController extends Controller
{
    public function __construct(Request $request = null) {

        parent::__construct($request);
        if(!Session::has('loginname')) {
            $this->redirect('/login');
        }
        $admin = Admin::get(Session::get('id'));
        if($admin['avatar'] == null || $admin['avatar'] == "")
            $admin['avatar'] = "static/images/avatar.png";
        $this->assign('admin', $admin);
    }

    public function Addlog($description, $status = 0) {
        Db::table('logs')->insert([
            'operator' => Session::get('id'),
            'url' => $this->request->url(true),
            'description' => $description,
            'ip' => $this->request->ip(),
            'status' => $status]);
    }
}