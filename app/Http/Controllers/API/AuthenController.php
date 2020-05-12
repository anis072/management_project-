<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

  /**   public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;

        if (!$token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Email or Password',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }*/
     /**  public function login(Request $request){
  $validation= $this->validate($request,[
           'email'  =>'required|email',
           'password'=>'required',
          ]);

       if(!Auth::attempt($validation)){
           return response(['status'=>'error','message'=>'user Undefined']);
       }
     $accesToken ='Bearer '.Auth::user()->createToken('TokenName')->accessToken;
     return response(['user'=>Auth::user(), 'acces_token'=>$accesToken]);
    }
    public function userauth(){
      return Auth::user();
    }*/




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

public function __construct()
{
    $this->middleware('auth:api', ['except' => ['login']]);
}

/**
 * Get a JWT token via given credentials.
 *
 * @param  \Illuminate\Http\Request  $request
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if ($token = $this->guard()->attempt($credentials)) {
        return $this->respondWithToken($token);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
}

/**
 * Get the authenticated User
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function me()
{
    return $this->guard()->user();
}

/**
 * Log the user out (Invalidate the token)
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function logout()
{
    $this->guard()->logout();

    return response()->json(['message' => 'Successfully logged out']);
}

/**
 * Refresh a token.
 *
 * @return \Illuminate\Http\JsonResponse
 */
public function refresh()
{
    return $this->respondWithToken($this->guard()->refresh());
}

/**
 * Get the token array structure.
 *
 * @param  string $token
 *
 * @return \Illuminate\Http\JsonResponse
 */
protected function respondWithToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'user'=> $this->guard()->user(),
        'expires_in' => $this->guard()->factory()->getTTL() * 60
    ]);
}

/**
 * Get the guard to be used during authentication.
 *
 * @return \Illuminate\Contracts\Auth\Guard
 */
public function guard()
{
    return Auth::guard('api');
}
}



