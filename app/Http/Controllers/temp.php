<?php 
include_once 'aliyuncs/aliyun-php-sdk-core/Config.php';
use Green\Request\V20180509 as Green;
 function img()
{
 data_default_timezone_set("PRC");
 $iClientProfile=DefaultProfile::getProfile("cn-shanghai","LTAIhYuwUZFs2Zol","joVRx54VcbeThQt841bDWYx2VwRULH");
 DefaultProfile::addEndpoint("cn-shanghai","Green","green.cn-shanghai.aliyuncs.com");
 $client=new DefaultAcsClient($iClientProfile);
 $request=new Green\ImageSyncScanRequest();
 $request->setMethod("POST");
 $request->setAcceptFormat("JSON");
 $task1=array('dataId'=>uniqid(),
			'url'=>'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1533637393552&di=ce7671a892a307f82b3a26d78a470fdc&imgtype=0&src=http%3A%2F%2Fimg535.ph.126.net%2Flvg6VJCGp3LIgQQqYDyijw%3D%3D%2F1298444067567396159.jpg',
			'time'=>round(microtime(true)*1000)
		);
 $request->setContent(json_encode(array("task"=>array($task1),
				"scenes"=>array("porn"))));

 try{
 	$response=$client->getAcsResponse($request);
 	print_r($response);
 	if(200==$response->code)
 	{
 		$taskResults=$response->data;
 		foreach($taskResults as $taskResult)
 		{
 			if(200==$taskResults->code)
 				{
 			$sceneResults=$taskResult->results;
 			foreach ($sceneResults as $sceneResult) {

 				$scene=$sceneResult->scene;
 				$suggestion=$sceneResult->suggestion;
 				print_r($scene);
 				print_r($suggestion);
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
 		print_r("detect not success.code:"+$response->code);
 	}

 }
 	catch(Exception $e)
 	{
 		print_r($e);
 	}
 }
?>
