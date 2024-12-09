<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{  
    public function __construct()
    {
       $this->middleware('auth:api',['except'=>['login','register']]) ;
    }
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>['required','email','unique:users','string'],
            'password'=>['required','string','min:6','confirmed'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $user=User::create(array_merge($validator->validated(),
        ['password'=>bcrypt($request->password)]
        ));
        $roles=Role::select('id')->where('name','users')->first();
        $user->roles()->attach($roles);
        return response()->json([
            'message'=>'user created successufly',
            'user'=>$user
        ],201);


    }

    public function login(Request $request){
        $validator=Validator::make($request->all(),[
            
            'email'=>['required','email'],
            'password'=>['required','string','min:6'],
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
    }
    return $this->createNewToken($token);
}
    public function createNewToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>"bearer",
            'expires_in' => config('jwt.ttl') * 60,
            'user'=>auth()->user()
        ]);
    }
    public function profile(){
        return response()->json(auth()->user());
    }
    public function logout(){
        auth()->logout();
        return response()->json(['message'=>'User logout']);
    }
}
