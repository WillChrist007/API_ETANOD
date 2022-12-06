<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Fundraising;

class FundraisingController extends Controller
{
    
    public function index()
    {
        $fundraisings=Fundraising::all();

        if(count($fundraisings)>0){
            return response([
                'message'=>'Retrieve All Success',
                'data'=>$fundraisings
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
            'dana'=>'required',
            'lokasi'=>'required',
            'durasi'=>'required'
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400);
        
            $fundraising=Fundraising::create($storeData);
            return response([
                'message'=>'add fundraising success',
                'data'=>$fundraising
            ],200);
    }

    public function show($id)
    {
        $fundraising=Fundraising::find($id);

        if(!is_null($fundraising)){
            return response([
                'message'=>'retrieve fundraising success',
                'data'=>$fundraising
            ],200);
        }

        return response([
            'message'=>'Fundraising not found',
            'data'=>null
        ],404);
    }

   
    public function update(Request $request, $id) 
    {
        $fundraising = Fundraising::find($id);
        if(is_null($fundraising)){
            return response([
                'message' => 'Fundraising Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'judul' => 'required',
            'dana' => 'required',
            'lokasi' => 'required',
            'durasi' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->error()], 400);

        $fundraising->judul = $updateData['judul'];
        $fundraising->dana = $updateData['dana'];
        $fundraising->lokasi = $updateData['lokasi'];
        $fundraising->durasi = $updateData['durasi'];

        if($fundraising->save()){
            return response([
                'message' => 'Update Fundraising Success',
                'data' => $fundraising
            ], 200);
        }

        return response([
            'message' => 'Update Fundraising Failed',
            'data' => null
        ], 400);
    }
    
    public function destroy($id)
    {
        $fundraising=Fundraising::find($id);

        if(is_null($fundraising)){
            return response([
                'message'=>'Fundraising not found',
                'data'=>null
            ],404);
        }

        if($fundraising->delete()){
            return response([
                'message'=>'delete Fundraising success',
                'data'=>$fundraising
            ],200);
        }

        return response([
            'message'=>'delete Fundraising failed',
            'data'=>null
        ],400);
    }
}
