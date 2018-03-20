<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 20/03/2018
 * Time: 2:09 PM
 */

namespace app\api\controller;

use app\api\model\Museum;
use think\Controller;

class MuseumControl extends Controller
{
    public function museum($id)
    {
        $museum = Museum::where('id', $id)->find();
        return json($museum);
    }
}