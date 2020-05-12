<?php

namespace App\Http\Controllers\API;
//use App\Http\Controllers\Controller;
use App\Projet;
use App\User;
use App\ProjetUser;
use App\Http\Controllers\BaseController ;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewProject;
use App\Notifications\NewProjectNotification;
use DB;
class ProjetController extends Controller
{
   public function __construct()
    {
       $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects= Projet::latest()->paginate(8);
        return response()->json([
            "projets"=> $projects
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



     public function store(Request $request)
    {
        $this->validate($request,[

            'name' => 'required|string|max:50',
            'duration' =>  'required|string|max:50',
            'description'=>'required|string|max:5000',
            'client' => 'required',
            'budget' => 'required',

              ]);


            $data = $request->all();
            $client = User::where('id', $data['client'])->first();
            $projet =new Projet;
            $projet->name = $data['name'];
            $projet->duration = $data['duration'];
            $projet->description = $data['description'];
            $projet->client_id = $data['client'];
            $projet->owner = $client->name;
            $projet->budget = $data['budget'];
            $projet->save();
            $ids=[$request->membre,$request->leader];
           $chef = User::whereIn('id' , $ids)->get();
      $data = array(
     'projet' => $projet->name,
     'id' => $projet->id,
    );
    $when = now()->addSeconds(10);
    Notification::send( $chef,new NewProjectNotification ($data));
         $when = now()->addSeconds(10);
    Notification::send( $chef,(new NewProject ($data))->delay($when));
    return response()->json([
        "action"=> "project created"
    ],200);
}
    public function getProjects()
    {
      $project= Projet::all();
      return response()->json([
        "project"=>$project
    ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   $data =$request->all();
        $this->validate($request,[

            'name' => 'string|max:50',
            'duration' =>  'string|max:50',
            'description'=>'string|max:50000',
            'client' => 'required',
            'budget' => 'required',
         ]);

       $client = User::where('id', $data['client'])->first();
        DB::table('projets')->where('id',$id)->update(['name'=>$data['name'],'duration'=>$data['duration'],'description'=>$data['description'],'owner'=>$client->name,'client_id'=>$data['client'],'budget'=>$data['budget']]);
        $chef = User::where('id' , $request->leader)->first();
        return response()->json([
        "action"=> "updated"
        ]);


       }

    public function updateparchef(Request $request, $id)
    {
        $data =$request->all();
        $client = Client::where('id', $data['client_id'])->first();
        DB::table('projets')->where('id',$id)->update(['name'=>$data['name'],'duration'=>$data['duration'],'description'=>$data['description'],'owner'=>$client->name,'client'=>$data['client'],'budget'=>$data['budget']]);
         return response()->json([
            "action"=> "updated"
        ]);
        return response()->json([
            "action "=>"update"
        ]);
    }
    public function role(Request $request){
        $data =$request->all();
        $role =new Role;
        $role->role=$data['role'];
        $role->save();
        return response()->json([
            "action"=> "role created"
        ]);
    }
    public function getrole(Request $request){
        return Role::latest()->paginate(100);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   //
        $projet=Projet::find($id);
        $projet->delete();

        return response()->json([
            "action"=> "project deleted"
        ]);
    }
    public function getProjectsUserConnecte(){
         $user=Auth::user();
        return $user->projets;
    }
    public function notifications()
    {
        $user= Auth()->user();
    return response([
        "user"=>$user
    ]);
    }

    public function adminp(){
      $projet =Projet::all();
      return response()->json([
          "projets"=>$projet
      ]);
   }

}
