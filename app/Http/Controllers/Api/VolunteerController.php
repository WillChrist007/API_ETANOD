<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Volunteer;

class VolunteerController extends Controller
{
    
    public function index()
    {
        $volunteers=Volunteer::all();

        if(count($volunteers)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$volunteers
            ],200);
        }

        return response([
            'message'=>'Empty',
            'data'=>null
        ],400);
    }


    public function store(Request $request)
    {
        $storeData=$request->all();
        $validate=Validator::make($storeData,[
            'judul'=>'required',
            'deskripsi'=>'required',
            'lokasi'=>'required',
            'waktu'=>'required'
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400);
        
            $volunteer=Volunteer::create($storeData);
            return response([
                'message'=>'add volunteer success',
                'data'=>$volunteer
            ],200);
    }

    public function show($id)
    {
        $volunteer=Volunteer::find($id);

        if(!is_null($volunteer)){
            return response([
                'message'=>'retrieve volunteer success',
                'data'=>$volunteer
            ],200);
        }

        return response([
            'message'=>'Volunteer not found',
            'data'=>null
        ],404);
    }

   
    public function update(Request $request, $id) 
    {
        $volunteer = Volunteer::find($id);
        if(is_null($volunteer)){
            return response([
                'message' => 'Volunteer Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'judul' => 'required',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'waktu' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $volunteer->judul = $updateData['judul'];
        $volunteer->deskripsi = $updateData['deskripsi'];
        $volunteer->lokasi = $updateData['lokasi'];
        $volunteer->waktu = $updateData['waktu'];

        if($volunteer->save()){
            return response([
                'message' => 'Update Volunteer Success',
                'data' => $volunteer
            ], 200);
        }

        return response([
            'message' => 'Update Volunteer Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $volunteer=Volunteer::find($id);

        if(is_null($volunteer)){
            return response([
                'message'=>'Volunteer not found',
                'data'=>null
            ],404);
        }

        if($volunteer->delete()){
            return response([
                'message'=>'delete Volunteer success',
                'data'=>$volunteer
            ],200);
        }

        return response([
            'message'=>'delete Volunteer failed',
            'data'=>null
        ],400);
    }
}
