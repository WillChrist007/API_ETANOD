<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData=$request->all();

        $validate= Validator::make($registrationData,[
            'username'=>'required',
            'email'=>'required',
            'password'=>'required',
            'tanggalLahir' => 'required',
            'telepon' => 'required'
        ]);        

        if($validate->fails()){
            return response(['message'=>$validate->errors()],400);
        }

        $registrationData['password']=bcrypt($request->password);

        $user=User::create($registrationData);

        return response([
            'message'=>'Register Success',
            'user'=>$user
        ],200);
    }

    public function login(Request $request){
        $loginData=$request->all();

        $validate=Validator::make($loginData,[
            'username'=>'required',
            'password'=>'required'
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400);

        if(!Auth::attempt(($loginData)))
            return response(['message'=>'Invalid Credentials'],401);
        
            $user=Auth::user();

            return response([
                'message'=>'Authenticated',
                'user'=>$user,
            ]);
    }

    public function logout(){
        $user = Auth::user()->token();
        $user->revoke();
        return response([
            'message'=>'Logout Success'
        ],200);
    }
}