<?php
/**
 * Created by PhpStorm.
 * User: WYH
 * Date: 26/03/2018
 * Time: 11:58 PM
 */

namespace app\api\controller;


use app\api\model\Audio;
use think\Controller;

class AudioControlApi extends Controller
{
    public function audio($id)
    {
        $audio = Audio::where('id', $id)->find();
        return json($audio);
    }

    public function user($userid) {
        $audio = Audio::Where('user_id', $userid)->find();
        return json($audio);
    }

    public function search()
    {
        if (request()->isGet()) {
            $data = input('get.');
            $audio = Audio::where('description', 'like', '%' . $data['description'] . '%')
                ->select();
            return json($audio);
        }
    }
}