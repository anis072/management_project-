<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Task;
use App\User;
use App\Projet;
use Illuminate\Support\Facades\Gate;
use DB;
use phpDocumentor\Reflection\Types\Boolean;
use App\Notifications\NewTask;
class TaskController extends Controller
{
	//
	public function __construct()
    {
//	  $this->middleware('auth:api');
        //    $this->authorizeResource('Chef');

    }
    public function store(Request $request){

	//	$this->authorize('Admin');
	//if (Gate::authorize('Admin')){
	    $task = new Task();
        $task->projet_id=$request->key;
		$task->text = $request->text;
		$task->start_date = $request->start_date;
		$task->duration = $request->duration;
		$task->progress = $request->has("progress") ? $request->progress : 0;
		$task->parent = $request->parent;
		$task->sortorder = Task::max("sortorder") + 1;

		$task->save();

		return response()->json([
			"action"=> "inserted",
			"tid" => $task->id
		]);

	}
   public function warning(){
//	return auth()->user()->tasks;
   }
	public function update($id, Request $request){

		$task = Task::find($id);

		$task->text = $request->text;
		$task->start_date = $request->start_date;
		$task->duration = $request->duration;
		$task->progress = $request->has("progress") ? $request->progress : 0;
		$task->parent = $request->parent;

		if($request->has("target")){
			$this->updateOrder($id, $request->target);
		}

		$task->save();

		return response()->json([
			"action"=> "updated"
		]);
	}

	private function updateOrder($taskId, $target){
		$nextTask = false;
		$targetId = $target;

		if(strpos($target, "next:") === 0){
			$targetId = substr($target, strlen("next:"));
			$nextTask = true;
		}

		if($targetId == "null")
			return;

		$targetOrder = Task::find($targetId)->sortorder;
		if($nextTask)
			$targetOrder++;

		Task::where("sortorder", ">=", $targetOrder)->increment("sortorder");

		$updatedTask = Task::find($taskId);
		$updatedTask->sortorder = $targetOrder;
		$updatedTask->save();
	}


	public function destroy($id){
//		$this->authorize('Admin');
		$task = Task::find($id);
		$task->delete();

		return response()->json([
			"action"=> "deleted"
		]);
    }
    public function getTask(){
      return $task = Task::orderBy('sortorder')->latest()->paginate(15);
      return response()->json([
        "Tasks"=> $task
    ]);
    }
    public function assign($id,$membre){
 //   $data=$request->all();
       $user=User::where('id',$membre)->first();
       $tasks = Task::where(['id'=>$id])->first();
       $tasks->user_id = $membre;
	   $tasks->save();
	   $projet=Projet::where('id',$tasks->projet_id)->first();
	   $data= array(
	   'id' => $tasks->id,
	   'projet' => $projet->name,
	   );
	   $user->notify(new NewTask($data));
    }
    public function hasparent(){
       $tasks =Task::all();
            $hasparent ="true";

        foreach( $tasks as $task ){
            if($task->id == $task->parent){
                $hasparent="true";
        }
        else{
            $hasparent="false";
        }

        }
        return $hasparent;
    }
    public function user(){
     $task =new Task;
     $users = User::where(['id'=>$id]);
     return $users;

    }
}
