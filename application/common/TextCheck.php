<?php

namespace app\common;

use think\Loader;
Loader::import('aliyuncs.aliyun-php-sdk-core.Config');
use Green\Request\V20170825 as Green;
date_default_timezone_set("PRC");


class TextCheck
{
    public function text($content) {
        $ak["accessKeyId"] = 'LTAIOGvwNGlBoif3';
        $ak["accessKeySecret"] = 'LLW8id0YOxYbwT0T4hoVFEHLLN0pq0';
        //请替换成你自己的accessKeyId、accessKeySecret
        $iClientProfile = \DefaultProfile::getProfile("cn-shanghai", $ak["accessKeyId"], $ak["accessKeySecret"]); // TODO
        \DefaultProfile::addEndpoint("cn-shanghai", "cn-shanghai", "Green", "green.cn-shanghai.aliyuncs.com");
        $client = new \DefaultAcsClient($iClientProfile);

        $request = new Green\TextScanRequest();
        $request->setMethod("POST");
        $request->setAcceptFormat("JSON");

        $task1 = array('dataId' =>  uniqid(),
            'content' => $content
        );
        $request->setContent(json_encode(array("tasks" => array($task1),
            "scenes" => array("antispam"))));

        try {
            $response = $client->getAcsResponse($request);
            if(200 == $response->code){
                $taskResults = $response->data;
                foreach ($taskResults as $taskResult) {
                    if(200 == $taskResult->code){
                        $sceneResults = $taskResult->results;
                        foreach ($sceneResults as $sceneResult) {
                            $scene = $sceneResult->scene;
                            $suggestion = $sceneResult->suggestion;
                            $label = $sceneResult->label;
                            if($suggestion == 'pass') {
                                return  ['suggestion' => $suggestion, 'label' => $label, 'labeltext' => '正常文本'];
                            }
                            else {
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
                                return  ['suggestion' => $suggestion, 'label' => $label, 'labeltext' => $labeltext];
                            }
                        }
                    }else{
                        return ['code' => $response->code, 'msg' => "task process fail"];
                    }
                }
            }else{
                return ['code' => $response->code, 'msg' => "detect not success. code"];
            }
        } catch (Exception $e) {
            return ['msg' => $e];
        }

    }
}