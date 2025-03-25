<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;

use function Laravel\Prompts\password;

class Authcontroller extends Controller
{
    public function createUser(Request $request){
            try {
             $ValditeUsers = FacadesValidator::make($request->all(),[
                'name'=> 'require',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min6'
            ]);

            if ($ValditeUsers->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $ValditeUsers->errors()
                ], 401);
            }
            $User = User::created([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=>Hash::make( $request->password),
                ]);
              
               return response()->json([
                'status' => false,
                'message' => 'User Created Successfully',
               ]);

               $token=JWTAuth::FromUser($User);
                
            } 
                catch (\Throwable $th) {
                    return response()->json([
                        'status' => false,
                        'message' => $th->getMessage()
                    ], 500);
                }
            }


public function login(Request $request){

    $credetinel=$request->only('email','password');


if(!$token=JWTAuth::attempt($credetinel)){
    return response()->json([
        'eruer'=>'Unauthorized' 
    ],401 );
}
return response()->json(['token' => $token]);

}





public function me()
{
    return response()->json(Auth::user()); 
}


public function logout()
{
    JWTAuth::invalidate(JWTAuth::getToken()); 
    return response()->json(['message' => 'Logged out successfully']);  
}

public function refresh()
{
        
    return response()->json([
        'user' => Auth::user(),
        'authorisation' => [
            'token' => Auth::refresh(),
            'type' => 'bearer',
        ]
    ]);
}




}