<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users=User::all();

        if(count($users)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$users
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }    

    public function show($id)
    {
        $user=User::find($id);

        if(!is_null($user)){
            return response([
                'message'=>'retrieve user success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'User not found',
            'data'=>null
        ],404);
    }

   
    public function update(Request $request, $id) 
    {
        $user = User::find($id);
        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'username'=>'required',
            'password'=>'required',
            'email'=>'required',
            'tanggalLahir'=>'required',
            'telepon'=>'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $user->nama = $updateData['nama'];
        $user->email = $updateData['email'];
        $user->password = $updateData['password'];

        if($user->save()){
            return response([
                'message' => 'Update User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $user=User::find($id);

        if(is_null($user)){
            return response([
                'message'=>'User not found',
                'data'=>null
            ],404);
        }

        if($user->delete()){
            return response([
                'message'=>'delete User success',
                'data'=>$user
            ],200);
        }

        return response([
            'message'=>'delete User failed',
            'data'=>null
        ],400);
    }
}
