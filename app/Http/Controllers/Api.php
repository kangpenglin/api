<?php

namespace App\Http\Controllers;
use App\image;
use App\text;
use Illuminate\Http\Request;
use App\Http\Controllers\temp;
class Api extends Controller
{
	public function image(Request $request)
	{
		$img=json_decode($request->input('img'));
		var_dump($img);
		if(count($img)==0)
		{
			return response()->json(
				[
				"code"=>"400","msg"=>"argument error"]);
		}
		$arr=array();
		foreach ($img as $i)
		{
			$arr[]=$i;
		}
	    img();
		return response()->json(
			["code"=>"200","msg"=>$arr]
		);
	}
}
