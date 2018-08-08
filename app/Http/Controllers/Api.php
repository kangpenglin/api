<?php

namespace App\Http\Controllers;
use App\image;
use App\text;
use Illuminate\Http\Request;
include_once 'temp.php';
class Api extends Controller
{
	public function image(Request $request)
	{
		$img=$request->input('img');
		$scene=$request->input('scene');
		if(count($img)==0)
		{
			return response()->json(
				[
				"code"=>"400","msg"=>"argument error"]);
		}
		
		$imgnew=array();
		foreach($img as $temp)
		{
			$resultmd=(string)md5($temp);
			$result=image::where('md',$resultmd)->get();
			if ($result->isEmpty())
				$imgnew[]=$temp;
			
		}
	        $code=200;	
		if (count($imgnew))	
			$code=img($imgnew,$scene);
		if($code!=200)
		{
			return response()->json(["code"=>$code,"msg"=>"picture read time out"]);
		}
		$imgnew=array();
		foreach($img as $temp)
			$imgnew[]=image::where('img',$temp)->get();
			
	   
		return response()->json(
			["code"=>"200","msg"=>"success","data"=>$imgnew]
		);
	}
}
