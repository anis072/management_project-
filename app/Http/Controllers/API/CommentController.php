<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Commentaire;
use App\Projet;
use App\User;
use App\ProjetUser;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewProjectCommentaire;
use App\Notifications\ResponseProjectCommentaire;
use App\Notifications\TaskReplyComment;
use App\Notifications\NewTaskComment;
class CommentController extends Controller
{
    //
    public function __construct(){

            $this->middleware('auth:api');

    }
    public function store($key){
         //$data =$request->all();
        $projet=Projet::find($key);
         $commentaire =new Commentaire;
         $commentaire->user_id= auth()->user()->id;
         $commentaire->body= request('body');
         $commentaire->comment_user_name=$commentaire->user->name;
         $commentaire->projet_id=$key;
        $projet->comments()->save($commentaire);

     $data= array(
         'id' => $projet->id,
         'projet' => $projet->name,
     );
     Notification::send($commentaire->projet->users->where('id','<>',auth()->user()->id),new NewProjectCommentaire($data));
    return response()->json([
        "action"=>"Commentaire added"
    ]);
    }
    public function storet($key){
        $task=Task::find($key);
        $commentaire =new Commentaire;
        $commentaire->user_id= auth()->user()->id;
        $commentaire->body= request('body');
        $commentaire->comment_user_name=$commentaire->user->name;
        $commentaire->task_id=$key;
       $task->comments()->save($commentaire);
       $projet=Projet::where('id',$task->projet_id)->first();
       $data= array(
        'id' => $task->id,
        'task' => $task->name,
    );
    Notification::send($projet->users->where('id','<>',auth()->user()->id),new NewTaskComment($data));
    return response()->json([
        "action"=>"Commentaire added"
    ]);
   }
    public function storereply(Request $request,$key){
        $data =$request->all();
        $user=User::find(Auth()->user()->id);
       $commentaire=Commentaire::find($key);
        $commentairereply =new Commentaire;
        $commentairereply->user_id= auth()->user()->id;
       $commentairereply->body = $data['body'];
       $commentairereply->comment_user_name=$user->name;
       //$commentairereply->projet_id=$commentaire->projet_id;
       $commentaire->comments()->save($commentairereply);
    $projet=Projet::where('id',$commentaire->projet_id)->first();
    $usersend=User::where('id',$commentaire->user_id)->first();
       $data= array(
        'id' => $projet->id,
        'projet' => $projet->name,
    );
    if ($usersend->id <> auth()->id()){
        Notification::send($usersend,new ResponseProjectCommentaire($data));
        }
        return response()->json([
            "action"=>"Commentaire reply added"
        ]);


   }
   public function storereplyt(Request $request,$key){
    $data =$request->all();
    $user=User::find(Auth()->user()->id);
   $commentaire=Commentaire::find($key);
    $commentairereply =new Commentaire;
    $commentairereply->user_id= auth()->user()->id;
   $commentairereply->body = $data['body'];
   $commentairereply->comment_user_name=$user->name;

   $commentaire->comments()->save($commentairereply);
   $task=Task::where('id',$commentaire->task_id)->first();

$usersend=User::where('id',$commentaire->user_id)->first();
   $data= array(
    'id' => $task->id,
    'task' => $task->name,
);
if ($usersend->id <> auth()->id()){
Notification::send($usersend,new TaskReplyComment($data));
}
return response()->json([
    "action"=>"Commentaire reply added"
]);
}
public function show(){
   // $commentaire =Commentaire::user()->name;
    $comments= Commentaire::where('commentable_type','App\Projet')->get();
    return response()->json([
        "comment"=>$comments
    ]);
}
public function showreply(){
    // $commentaire =Commentaire::user()->name;
   $comment=Commentaire::where('commentable_type','App\Commentaire')->get();

   return response()->json([
    "commentreply"=>$comment
]);
 }
 public function showt(){
    // $commentaire =Commentaire::user()->name;
      $comment= Commentaire::where('commentable_type','App\Task')->get();
     return response()->json([
        "comment"=>$comment
    ]);
 }

}
