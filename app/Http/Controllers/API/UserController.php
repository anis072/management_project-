<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Projet;
use App\Mail\loginMail;
use App\Mail\ClientMail;
use Illuminate\Support\Facades\Mail;
use DB;
class UserController extends Controller
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
        //
        return User::where('role','<>','chef de projet')->where('role','<>','admin')->where('role','<>','client')->latest()->paginate(10);

    }
    // bloc chef de projet
    public function chef(){
        return User::where('role','chef de projet')->latest()->paginate(10);
    }
   
  public function  ajouterChefDeProjet(Request $request){
  $validator= $this->validate($request,[
          'name' => 'required|string|min:3|max:20',
          'email' =>'required|string|email|unique:users',
          'password'=> 'required|string|min:6',
          'tel' => 'required'
           ]);
           $data = array( 
            'login'    => $request->email,
            'password' => $request->password,
            'role'  => "chef de projet"
        );

        Mail::to($request->email)->send(new loginMail($data));

        return User::create([
            'name' => $request->name,
           'email'=> $request->email,
           'password'=> bcrypt($request->password),
           'tel'=> $request->tel,
           'role'=> "chef de projet"

       ]);


    }
    //bloc client
    public function  ajouterClient(Request $request){
        $validator= $this->validate($request,[
                'name' => 'required|string|min:3|max:20',
                'email' =>'required|string|email|unique:users',
                'password'=> 'required|string|min:6',
                'tel' => 'required'
                 ]);
                 $data = array( 
                    'login'    => $request->email,
                    'password' => $request->password,
                    'name'  => $request->name
                );
        
                Mail::to($request->email)->send(new ClientMail($data));
              return User::create([
                  'name' => $request->name,
                 'email'=> $request->email,
                 'password'=> bcrypt($request->password),
                 'tel'=> $request->tel,
                 'role'=> "client"
      
             ]);
      
      
          }
          public function client(){
            return User::where('role','client')->latest()->paginate(10);
        }
        /*public function nomdeprojet(Request $request){
            $data =$request->all();
            $client = User::where('role','client')->get();
      return  $projets=Projet::where('id',$client->id);
    
    
       }*/
      /* public function updatename(Request $request ){
      $data =$request->all();
      User::where('id',$data['client_id'])->update(['project_name'=>$data['client_id']]);
       }*/

       //bloc pour modification des données user connecté
    public function updateuserconnecté(Request $request){
        $id=Auth()->user()->id;
        $user=User::find($id);
        $user->update(['email'=>$request->email,'password'=>bcrypt($request->password)]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'name' => 'required|string|min:3|max:20',
            'email' =>'required|string|email|unique:users',
            'password'=> 'required|string|min:6',
            'tel' => 'required',
            'role' => 'required'
             ]);
             $data = array( 
                'login'    => $request->email,
                'password' => $request->password,
                'role'  => $request->role
            );
  
            Mail::to($request->email)->send(new loginMail($data));
        return User::create([
                'name' => $request->name,
                'email'=> $request->email,
                'password'=> bcrypt($request->password),
                'tel'=> $request->tel,
                'role'=> $request->role,
               
            ]);




        }
        public function clientprojet(){

            return User::where('role','client')->latest()->paginate(100);
    
        }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function Membreprojet()
    {
        return User::where('role','<>','admin')->where('role','<>','chef de projet')->where('role','<>','client')->latest()->paginate(100);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $requestwhere
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $user=User::find($id);
         $this->validate($request,[
            'name' => 'string|min:3|max:20',
            'email' => 'string|email|unique:users,email,'.$user->id,
           //'password'=> 'string|min:6',
            //'tel' => 'min:8|max:8'
             ]);
             
          $data = $request->all();
          if ($user->role === 'chef de projet'){
  DB::table('users')->where('id',$id)->update(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'tel'=>$data['tel']]);
               }
               else if($user->role === 'client'){
  DB::table('users')->where('id',$id)->update(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'tel'=>$data['tel']]);
  DB::table('projets')->where('client_id',$id)->update(['owner'=>$data['name']]);
               }
               else {
  DB::table('users')->where('id',$id)->update(['name'=>$data['name'],'email'=>$data['email'],'password'=>bcrypt($data['password']),'tel'=>$data['tel'],'role'=>$data['role']]);
               }
    }
    public function chefprojet(){
    return User::where('role','chef de projet')->latest()->paginate(150);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
       User::find($id)->delete();
    }
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

       if($request->email != null){
        $this->validate($request,[
            'email' =>'string|email|unique:users',
        ]);
       }
        if($request->password != null){
            $this->validate($request,[
                'password' => 'min:6',
            ]);
        }
            if($request->location != null){
                $this->validate($request,[
                    'location' => 'string|min:6|max:191',
                ]);
            }
                if($request->education != null){
                    $this->validate($request,[
                        'education' => 'string|min:3|max:191',
                    ]);
                    }
                    if($request->education != null){
                    $this->validate($request,[
                        'location' => 'string|min:6|max:191',
                    ]);
                    }

          if($request->photo !=null){


        $currentPhoto = $user->photo;


        if($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
            //    @unlink($userPhoto);
            }
}

   if($request->email != null){
   $user->email=$request->email;
   $user->save();
  }
  if($request->password != null){
    $user->password=bcrypt($request->password);
    $user->save();
   }
   if($request->education != null){
    $user->education=$request->education;
    $user->save();
   }
   if($request->location != null){
    $user->location=$request->location;
    $user->save();
   }
   if($request->skills != null){
    $user->skills=$request->skills;
    $user->save();
   }
   if($request->photo != null){
    $user->photo=$request->photo;
    $user->save();
   }

        return ['message' => "Success"];
    }
else {

    if($request->email != null){
        $user->email=$request->email;
        $user->save();
       }
       if($request->password != null){
         $user->password=bcrypt($request->password);
         $user->save();
        }
        if($request->education != null){
         $user->education=$request->education;
         $user->save();
        }
        if($request->location != null){
         $user->location=$request->location;
         $user->save();
        }
        if($request->skills != null){
         $user->skills=$request->skills;
         $user->save();
        }
        if($request->photo != null){
         $user->photo=$request->photo;
         $user->save();
        }
}


}
public function Membrechefprojet()
    {
        return User::where('role','<>','admin')->latest()->paginate(100);
    }
}
