<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function login(Request $request){
  $validation= $this->validate($request,[
           'email'  =>'required|email',
           'password'=>'required',
          ]);

       if(!Auth::attempt($validation)){
           return response(['status'=>'error','message'=>'user Undefined']);
       }
     $accesToken =Auth::user()->createToken('TokenName')->accessToken;
     return response(['user'=>Auth::user(), 'acces_token'=>$accesToken]);
    }
    public function userauth(){
      return Auth::user();
    }




        /**    $http = new GuzzleHttp\Client;

$response = $http->post(url('oauth/token'), [
    'form_params' => [
        'grant_type' => 'password',
        'client_id' => '2',
        'client_secret' => '2lYpao3Z1uBp86TCLbHGcPh31845810PdgzpgCof',
        'username' => $request->email,
        'password' => $request->password,
        'scope' => '',
    ],

]);**/



}

