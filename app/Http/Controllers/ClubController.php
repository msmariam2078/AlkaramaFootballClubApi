<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Sport;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploader;
use App\Http\Resources\ClubResource;
use Illuminate\Support\Str;
class ClubController extends Controller
{ use GeneralTrait, FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
 
     public function index(){
    $clubs=Club::all();
    if($clubs->isEmpty()){
    return $this->notFoundResponse('not found clubs');}
     else{
     $clubs=ClubResource::collection($clubs);
     return $this->apiResponse($clubs);
     }}
 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validate = Validator::make($request->all(),[
        'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'address' => 'required|string',
        'logo' => 'required|file|mimes:jpg,png,jpeg,jfif',
        "sport_uuid"=>'required|string|exists:sports,uuid'
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        }
        try{
        $logo=$this->uploadImagePublic2($request,'club','logo');
        if(!$logo)
        {
        return  $this->apiResponse(null, false,'Failed to upload image',500); 
         }

        else{
         $uuid=Str::uuid();
        $sport_id=Sport::where('uuid',$request->input('sport_uuid'))->value('id');
        $club=Club::firstOrCreate(['uuid'=>$uuid,
        'name'=>$request->input('name'),
        'address'=>$request->input('address'),
        'logo'=>$logo,
        'sport_id'=>$sport_id,

    ]);
        $club=ClubResource::make($club); 
        return $this->apiResponse($club) ;  
        
       


    }  } catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$uuid)
    {  $validate = Validator::make($request->all(),[
        'name' => 'string|min:2|max:20|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'address' => 'string',
        'image' => 'file|mimes:jpg,png,jpeg,jfif',
    
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        }
        try{
        $club=Club::where('uuid',$uuid)->first();
        if(!$club)
        {
         return $this->notFoundResponse('not found replacements');

        }
        else{
        $club->update($request->all());
        if($request->image) {
        $this->deleteFile($club->logo);
        $logo=$this->uploadImagePublic2($request,'club','image');
        if(!$logo){
        return  $this->apiResponse(null, false,'Failed to upload image',500);
        }
        else{
        $club->logo=$logo;
        $club->save();}
 
        }
   
    return  $this->apiResponse( 'updated successfuly');
    
    }}
    catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Club  $club
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    {   
       $club=Club::where('uuid',$uuid); 
       if(!$club)
       {
       return $this->notFoundResponse("cannot deleted this club");
       }
       else{
       $club->delete();
       return $this->apiResponse("deleted successfully!");
    }
}
}