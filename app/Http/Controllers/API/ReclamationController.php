<?php
namespace App\Http\Controllers\API;

use App\Filee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reclamation;
use App\Projet;
use App\User;
use App\ProjetUser;
use App\TypeComplain;
use Illuminate\Support\Facades\Notification;
use App\Notifications\reclamationNotification;
use App\Notifications\reclamationAssigned;
use App\Notifications\NewComplaint;
use App\Notifications\ComplaintProcessed;
use App\Notifications\ComplaintFinished;
use App\Notifications\SendComplaintToLeader;
use App\Notifications\AlertComplaint;
use DB;
class ReclamationController extends Controller
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
    {  $user= Auth()->user();
        if ($user->role === 'admin')
        {
         $complain= Reclamation::latest()->paginate(8);
        return response()->json([
           "complain"=>$complain
        ]);
        }
      else  if ($user->role === 'client')
        {
            $complain= Reclamation::where('client_id',Auth()->id())->latest()->paginate(5);
            return response()->json([
                "complain"=>$complain
             ]);
        }
     else if ($user->role === 'chef de projet')
        {
            $complain= Reclamation::where('chef_id',Auth()->id())->latest()->paginate(8);
            return response()->json([
                "complain"=>$complain
             ]);
        }
        else {
            $complain=Reclamation::where('employe_id',Auth()->id())->latest()->paginate(8);
            return response()->json([
                "complain"=>$complain
             ]);
        }
    }
    public function complaints(){
        $complain= Reclamation::all();
        return response()->json([
           "complain"=>$complain
        ]);
        }


  public function  projets(){
    $project= Projet::where('client_id',Auth()->id())->get();
    return response()->json([
       "projects"=>$project
    ]) ;
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

            'type' => 'required',
            'description' =>  'required|string|max:5000',
             'project'=>'required'

              ]);

          $data = $request->all();
          $projet=Projet::where('id',$data['project'])->first();
          $userprojet= ProjetUser::where('projet_id',$data['project'])->where('role','chef de projet')->first();
          $client= User::where('id',Auth()->id())->first();
          $reclamation = new Reclamation;
          $reclamation->type= $data['type'];
          $reclamation->description= $data['description'];
          $reclamation->avancement= 'Filing of complaint';
          $reclamation->client_id= Auth()->id();
          $reclamation->projet_id=$data['project'];
          $reclamation->nameProjet=$projet->name;
          $reclamation->chef_id=$userprojet->user_id;
          $reclamation->nameClient=$client->name;
          $reclamation->progress=25;
          $reclamation->save();
          $user = User::find($userprojet->user_id);
          $data = array(
           'type' => $reclamation->type,
           'projet' => $projet->name,
           'id' => $reclamation->id,
          );
          $user->notify(new reclamationNotification($data));
          $when = now()->addSeconds(10);
          Notification::send( $user,(new NewComplaint ($data))->delay($when));
          return response()->json([
            "action"=>"Complain Added"
          ]);
    }
    public function complaintsfile(Request $request){
        $reclamation = Reclamation::latest('updated_at')->first();
        $file = new Filee;
        if(!$request->hasFile('file')){
        return response()->json([
            "action"=>"File empty"
        ]);
        }
        else{
            $this->validate($request,[
             'file' => 'required|mimes:doc,png,jpg,docx,txt|max:2048'
              ]);
        $extention = time().'.'.$request->file->getClientOriginalExtension();
        $fileName ="complain".'.'.$extention;
        $request->file->move(public_path('upload'), $fileName);
        $file->file= $fileName;
        $file->rec_id=$reclamation->id;
        $file->save();
        }

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
    {
      $data=$request->all();
     $reclamation = Reclamation::where('id',$id)->first();
     $reclamation->avancement= $data['etat'];
     if ($data['etat'] == 'In progress'){
         $reclamation->progress= 50;
         $reclamation->save();
     }
    else if ($data['etat'] == 'Pending Team leader validation'){
        $reclamation = Reclamation::where('id',$id)->first();
        $reclamation->avancement= $data['etat'];
          $reclamation->progress= 75;
          $reclamation->save();
         $chef =User::where('id',$reclamation->chef_id)->first();
         $data= array (
            'id' => $reclamation->id,
            'projet' => $reclamation->nameProjet,
            );
            Notification::send($chef,new SendComplaintToLeader($data));
     }
     return response()->json([
        "action"=>"Complain Updated"
      ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign($id,$membre){
              $user=User::where('id',$membre)->first();
              $reclamation = Reclamation::where(['id'=>$id])->first();
              $reclamation->employe_id = $membre;
              $reclamation->nameEmp=$user->name;
              $reclamation->save();
              $data = array(
                'type' => $reclamation->type,
                'projet' => $reclamation->nameProjet,
                'id' => $reclamation->id,
               );
               Notification::send( $user,new reclamationAssigned ($data));
               $when = now()->addSeconds(10);
               Notification::send( $user,(new NewComplaint ($data))->delay($when));
           return response()->json([
               "action"=>"complain asigned"
           ]);
            }
           public function type(Request $request){
            $data =$request->all();
            $type =new TypeComplain;
            $type->type=$data['type'];
            $type->save();

        }
        public function gettype(Request $request){
            $type= TypeComplain::all();
            return response()->json([
                "type"=>$type
            ]);
        }
     public function terminerReclamation($id){
     $reclamation = Reclamation::where('id',$id)->first();
     $reclamation->avancement= "Finished" ;
     $reclamation->progress= 100;
     $reclamation->save();
     $user =User::where('id',$reclamation->employe_id)->first();
     $client= User::where('id',$reclamation->client_id)->first();
     $data= array (
     'id' => $reclamation->id,
     'projet' => $reclamation->nameProjet,
     );
     Notification::send($user,new ComplaintFinished($data));
     $when = now()->addSeconds(10);
     Notification::send( $client,(new ComplaintProcessed($data))->delay($when));
     return response()->json([
         "action"=>"complain finished"
     ]);
    }
        public function alertReclamation($id){
            $reclamation = Reclamation::where('id',$id)->first();
            $user =User::where('id',$reclamation->employe_id)->first();
            $data= array (
                'id' => $reclamation->id,
                'projet' => $reclamation->nameProjet,
                );
                Notification::send($user,new AlertComplaint($data));
         return response()->json([
             "action"=>"added alert"
         ]);
            }
    public function destroy($id)
    {
        $reclamation=Reclamation::find($id);
        $reclamation->delete();
        return ["result" => "Complain Deleted"];
    }
}
