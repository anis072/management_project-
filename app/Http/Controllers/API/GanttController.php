<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Task;
use App\Link;

class GanttController extends Controller
{
	public function get($id){
        $tasks= new Task;
//if($tasks->projet_id== $id){
		$tasks = new Task();
		$links = new Link();

		return response()->json([
			"data" => $tasks->where('projet_id',$id)->orderBy('sortorder')->get(),
			"links" => $links->all()
		]);
    }
   // else{
  //      return response()->json([
	//		"failed"
	//				]);
    //}
}
