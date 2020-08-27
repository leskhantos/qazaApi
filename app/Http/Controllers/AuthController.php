<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api',['except'=>['login','register']]);
    }
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|between:2,100',
            'email' => 'required|email|unique:users|max:50',
            'password' => 'required|confirmed|string|min:6',
            'date_of_birth' => 'date_format:Y-m-d|before:today|required'
        ]);
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'Successfully registered',
            'user' => $user
        ], 201);
    }
    public function login(){
        $credentials = \request(['email','password']);
        if (! $token = auth()->attempt($credentials)){
            return response()->json(['error'=>'Invalid email or pass'],401);
        }
        return $this->respondWithToken($token);
    }
    private function respondWithToken($token){
        return response()->json([
            'token'=>$token,
            'access_type'=>'bearer'
        ]);
    }
    public function logout(){
        auth()->logout();
        return response()->json(['msg'=>'User logged out']);
    }
    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }
    public function me(){
        return response()->json(auth()->user());
    }
}
