<?php

namespace App\Http\Controllers;

use App\Models\Topfan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


use App\Http\Resources\TopfanResource;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\Association;




class TopfanController extends Controller
{      use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topfan=Topfan::all();
   
   
       
            $topfan=TopfanResource::collection( $topfan);
         return $this->apiResponse($topfan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
        
            $validate = Validator::make($request->all(),[
                'name'=>'string|min:2|max:20|required',
             
                 "association_uuid"=>'required|string|exists:associations,uuid',
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
          
    
                 $uuid=Str::uuid();
    $association_id=Association::where('uuid',$request->input('association_uuid'))->value('id');

            $topfan=Topfan::firstOrCreate(['uuid'=>$uuid,
            'name'=>$request->input('name'),
          
            'association_id'=>$association_id,
    
        ]);
        $topfan= TopfanResource::make($topfan); 
            return $this->apiResponse( $topfan) ;  
            
           
    
    
          } catch (\Throwable $th) {
          
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Topfan  $topfan
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try{
            $topfan= Topfan::where('uuid',$uuid)->first();
           
            if(!$topfan)
            {
                return $this->apiResponse(null,false,['not found'],404); 
            }
      
            $topfan=TopfanResource::make($topfan);
            return $this->apiResponse($topfan); 

           } catch (\Throwable $th) {
                  
           return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topfan  $topfan
     * @return \Illuminate\Http\Response
     */
    public function edit(Topfan $topfan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topfan  $topfan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $topfan=Topfan::find($uuid);
        $validate = Validator::make($request->all(),[
       'name'=>'string|min:2|max:20|required',
    
        "association_uuid"=>'required|string|exists:associations,uuid',
   
    
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        }
        try{
            $topfan=Topfan::where('uuid',$uuid)->first();
        if(!$topfan)
        {
         return $this->notFoundResponse(['not found']);

        }
        else{
            $topfan->update($request->all());
     
   
    return  $this->apiResponse( ['updated successfuly']);
    }}
    catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topfan  $topfan
     * @return \Illuminate\Http\Response
     */


    public function destroy($uuid)
    {
        $topfan=Topfan::where('uuid',$uuid)->first(); 
       if(!$topfan)
       {
       return $this->notFoundResponse(["cannot deleted "]);
       }
       else{
       $topfan->delete();
       return $this->apiResponse(["deleted successfully!"]);
         }
    }
    
}      



