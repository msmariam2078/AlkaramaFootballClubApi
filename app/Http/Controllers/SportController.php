<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploader;
use Illuminate\Support\Str;
use App\Http\Resources\SportResource;
class SportController extends Controller
{   use GeneralTrait,FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $sports=Sport::all();
        $sports=SportResource::collection($sports);
         return $this->apiResponse($sports);
         }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            //'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
            'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/|unique:sports,name',
            'image' => 'required|file|mimes:jpg,png,jpeg,jfif|max:2000',
                    ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
            $image='';
          if($request->image)
          {
            $image=$this->uploadImagePublic2($request,'sports','image');
            if(!$image)
            {
                return $this->apiResponse(null,false,['failed to upload image'],500);
            }

          }
            $sport = Sport::firstOrCreate( [
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'image' => $image,
          
                    ]);
            $sport = SportResource::make($sport);
            return $this->apiResponse($sport);
            
                }   catch (\Throwable $th) {
                  
                    return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function show( $uuid)
    {
           
        try{
            $sport= Sport::where('uuid',$uuid)->first();
           
            if(!$sport)
            {
                return $this->apiResponse(null,false,['not found'],404); 
            }
      
            $sport=SportResource::make($sport);
            return $this->apiResponse($sport); 

           } catch (\Throwable $th) {
                  
           return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function edit(Sport $sport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sport $sport)
    {
        $validate = Validator::make($request->all(),[
     
            'name' => 'string|min:2|max:20|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/|unique:sports,name',
         
            'sport_image' => 'file|mimes:jpg,png,jpeg,jfif|max:2000',
        
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
            $sport=Club::where('uuid',$uuid)->first();
            if(!$sport)
            {
             return $this->notFoundResponse(['not found replacements']);
    
            }
            else{
            $sport->update($request->all());
            if($request->sport_image) {
            $this->deleteFile($sport->image);
            $image=$this->uploadImagePublic2($request,'club','sport_image');
            if(!$image){
            return  $this->apiResponse(null, false,['Failed to upload image'],500);
            }
            else{
            $sport->image=$image;
            $sport->save();}
     
            }
       
        return  $this->apiResponse( ['updated successfuly']);
        
        }}
        catch (\Throwable $th) {
          
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sport  $sport
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    {
        $sport = Sport::where('uuid',$uuid)->first(); 
        if(!$sport)
        {
         return $this->notFoundResponse(['notfound']);
        }
        else{
        $plan->delete();
        return $this->apiResponse(["succssifull delete"],true,null,201);
     }
    }
}
