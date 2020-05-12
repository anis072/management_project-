<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Projet;
use App\Task;
use App\User;

class StatController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:api');
    }
    //
    public function Nprojects(){
        $projects=Projet::all()->count();
        return response()->json([
        "projects"=>$projects
        ]);
    }
    public function Uprojects(){
        $Uprojects=auth()->user()->projets->count();
        return response()->json([
        "projects"=>$Uprojects
        ]);
    }
    public function Nclients(){
        $clients=User::where('role','client')->get()->count();
        return response()->json([
        "clients"=>$clients
        ]);
    }
    public function Nleaders(){
        $leaders=User::where('role','chef de projet')->get()->count();
        return response()->json([
        "leaders"=>$leaders
        ]);
    }
    public function Nusers(){
        $users= User::where('role','<>','chef de projet')->where('role','<>','admin')->where('role','<>','client')->get()->count();
        return response()->json([
        "users"=>$users
        ]);
    }
    public function stats(){
        $project=Projet::orderBy('progress','DESC')->latest()->paginate(5);
        return response()->json([
         "projectstat"=>$project
        ]);
    }
    public function Ustats(){//Probleme de sort by
        $Uproject=auth()->user()->projets;
        return response()->json([
         "projectstat"=>$Uproject
        ]);
    }
    public function Utasks(){
        $Utasks=Task::where('user_id',auth()->user()->id)->orderBy('progress','DESC')->latest()->paginate(6);
        return response()->json([
         "tasks"=>$Utasks
        ]);
    }
    public function  Cprojets(){
        $project= Projet::where('client_id',Auth()->id())->orderBy('progress','DESC')->latest()->paginate(6);
        return response()->json([
           "projects"=>$project
        ]) ;
    }
}
