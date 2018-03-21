<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 20/03/2018
 * Time: 2:09 PM
 */

namespace app\api\controller;

use think\Controller;
use app\api\model\Museum;


class MuseumControlApi extends Controller
{
    public function museum($id)
    {
        $museum = Museum::where('id', $id)->find();
        return json($museum);
    }
}