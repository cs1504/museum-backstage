<?php

namespace app\common;

use think\Loader;
Loader::import('aliyuncs.aliyun-php-sdk-core.Config');
use Green\Request\V20170825 as Green;
date_default_timezone_set("PRC");
use think\Db;

class AudioCheck
{
    public function request($url) {
        $ak["accessKeyId"] = Db::table('options')->where('option_name', 'aliyunak')->value('option_value');
        $ak["accessKeySecret"] = Db::table('options')->where('option_name', 'aliyunsk')->value('option_value');;
        //请替换成你自己的accessKeyId、accessKeySecret
        $iClientProfile = \DefaultProfile::getProfile("cn-shanghai", $ak["accessKeyId"], $ak["accessKeySecret"]); // TODO
        \DefaultProfile::addEndpoint("cn-shanghai", "cn-shanghai", "Green", "green.cn-shanghai.aliyuncs.com");
        $client = new \DefaultAcsClient($iClientProfile);

        $request = new Green\VoiceAsyncScanRequest();
        $request->setMethod("POST");
        $request->setAcceptFormat("JSON");

        $task1 = array(
            'dataId' =>  uniqid(),
            'type' => 'file',
            'url' => $url,
            'time' => time()
        );
        $request->setContent(json_encode(array("tasks" => array($task1),
            "scenes" => array("antispam"))));

        try {
            $response = $client->getAcsResponse($request);
            if(200 == $response->code){
                $taskResults = $response->data;
                return (array)$taskResults[0];
            }else{
                return ['code' => $response->code, 'msg' => "detect not success. code"];
            }
        } catch (Exception $e) {
            return ['code' => 400, 'msg' => $e];
        }
    }

    public function response($taskId, $dataId) {
        $ak["accessKeyId"] = Db::table('options')->where('option_name', 'aliyunak')->value('option_value');
        $ak["accessKeySecret"] = Db::table('options')->where('option_name', 'aliyunsk')->value('option_value');;
        //请替换成你自己的accessKeyId、accessKeySecret
        $iClientProfile = \DefaultProfile::getProfile("cn-shanghai", $ak["accessKeyId"], $ak["accessKeySecret"]); // TODO
        \DefaultProfile::addEndpoint("cn-shanghai", "cn-shanghai", "Green", "green.cn-shanghai.aliyuncs.com");
        $client = new \DefaultAcsClient($iClientProfile);

        $request = new Green\VoiceAsyncScanResultsRequest();
        $request->setMethod("POST");
        $request->setAcceptFormat("JSON");

        $request->setContent(json_encode(array(array(
            "taskId" => $taskId,
            "dataId" => $dataId
        ))));

        try {
            $response = $client->getAcsResponse($request);

            $response = $client->getAcsResponse($request);
            if(200 == $response->code) {
                $taskResult = $response->data[0];
                if(200 == $taskResult->code) {
                    $result = $taskResult->results[0];
                    $details = $result->details;
                    $content = '';
                    foreach ($details as $detail) {
                        if($detail->label != 'normal') {
                            $content .= '<b style="color: blue; font-size: 20px;"><i>';
                            $content .= $detail->text;
                            $content .= '</i></b>';
                            $content .= " ";
                        }
                        else {
                            $content .= $detail->text;
                            $content .= " ";
                        }
                    }
                    $label = $result->label;
                    switch ($label) {
                        case 'spam' : $labeltext = '含垃圾信息'; break;
                        case 'ad' : $labeltext = '含广告信息'; break;
                        case 'politics' : $labeltext = '含涉政信息'; break;
                        case 'terrorism' : $labeltext = '含暴恐信息'; break;
                        case 'abuse' : $labeltext = '含辱骂信息'; break;
                        case 'porn' : $labeltext = '含色情信息'; break;
                        case 'flood' : $labeltext = '含灌水信息'; break;
                        case 'contraband' : $labeltext = '含违禁信息'; break;
                        case 'meaningless' : $labeltext = '无意义信息'; break;
                        default : $labeltext = '含其他违禁信息'; break;
                    }
                    return [
                        'code' => 200,
                        'content' => $content,
                        'label' => $label,
                        'labeltext' => $labeltext,
                        'suggestion' => $result->suggestion
                    ];
                }
                elseif (280 == $taskResult->code) {
                    return [
                        'code' => 280,
                        'msg' => '任务正在执行中'
                    ];
                }
                else {
                    return [
                        'code' => 400,
                        'msg' => '检测失败，或者未能检测出语句'
                    ];
                }

            }
        } catch (Exception $e) {
            return [
                'code' => 500,
                'msg' => '请求出现问题，稍后重试:'.$e
            ];
        }

    }
}

//
//object(stdClass)#1257 (5) {
//["code"] => int(200)
//["dataId"] => string(13) "5aecfcff5e45c"
//["msg"] => string(2) "OK"
//["taskId"] => string(34) "vc_f_6Ku@Z$mxAxz4tX95v5VzKk-1oOSYh"
//["url"] => string(87) "http://p4buh8sqx.bkt.clouddn.com/%E8%B5%B5%E9%9B%B7-%E6%88%90%E9%83%BD%20%28Live%29.mp3"
//}