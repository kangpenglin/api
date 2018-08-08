<?php
use App\image;
include_once 'aliyun-php-sdk-core/Config.php';
use \Green\Request\V20180509 as Green;
#data_default_timezone_set("PRC");
 function img($imgUrl,$scenes)
 {
        $iClientProfile=DefaultProfile::getProfile("cn-shanghai","LTAIhYuwUZFs2Zol","joVRx54VcbeThQt841bDWYx2VwRULH");
        DefaultProfile::addEndpoint("cn-shanghai","cn-shanghai","Green","green.cn-shanghai.aliyuncs.com");
        $client=new DefaultAcsClient($iClientProfile);
        $request=new Green\ImageSyncScanRequest();
        $request->setMethod("POST");
	$request->setAcceptFormat("JSON");
	$task2=array();
	foreach($imgUrl as $tempImg)
	{
        $task1=array('dataId'=>uniqid(),
			'url'=>$tempImg,
			'time'=>round(microtime(true)*1000)
	        	);
	$task2[]=$task1;
	}
	
        $request->setContent(json_encode(array("tasks"=>$task2,
				"scenes"=>array($scenes))));

       try{
	       $response=$client->getAcsResponse($request);
	       
 	if(200==$response->code)
 	{
 		$taskResults=$response->data;
 		foreach($taskResults as $taskResult)
 		{
 			if(200==$taskResult->code)
 				{
					$sceneResults=$taskResult->results;
					$lasturl=$taskResult->url;
					$lasttaskId=$taskResult->taskId;
					
 			foreach ($sceneResults as $sceneResult) {

 				$scene=$sceneResult->scene;
				$suggestion=$sceneResult->suggestion;
				$label=$sceneResult->label;
				$imageTable=new image();
				$imageTable->img=$lasturl;
				$imageTable->type=$scene;
				$imageTable->taskId=$lasttaskId;
				$imageTable->label=$label;
				$imageTable->response=$suggestion;
				$imageTable->md=md5($lasturl);
				$imageTable->save();
 			}
 				}
 			else
 			{
 				print_r("task process fail"+$response->code);
 			}
 		}
	}

 	else
 	{
 		return $response->code;
 	}

 }
 	catch(Exception $e)
 	{
 		print_r($e);
 	}
 }
?>
