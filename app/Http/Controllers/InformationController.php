<?php

namespace App\Http\Controllers;

use App\Models\Information;
use App\Models\Session;
use App\Models\Club;
use Illuminate\Support\Str;
use App\Models\Matching;
use Illuminate\Http\Request;
use App\Http\Traits\FileUploader;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\InformationResource;
use App\Http\Traits\GeneralTrait;
class InformationController extends Controller
{  use GeneralTrait,FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByType(Request $request)
    {   
     $validate = Validator::make($request->all(),[
      
    "type"=>'required|string|in:news,regular,strategy,regular,slider'
     ]);
    if($validate->fails()){
    return $this->requiredField($validate->errors()->first());    
     }
    try{
    $information=Information::where('uuid',$uuid)->first();
    if(!$information){
    return $this->apiResponse('not found information');
         }
       
     $information=Information::where('type',$request->type)->get();
     $information=InformationResource::collection($information);
     return $this->apiResponse($information);
    } catch (\Throwable $th) {
              
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
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
   
    public function informationMatch( Request $request,$uuid)
    {
        $validate = Validator::make($request->all(),[
        
        'title' => 'string|min:20|max:100|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'content' => 'required|string|min:20|max:1000',
        'image' => 'required|file|mimes:jpg,png,jpeg,jfif|max|2000',
        "type"=>'required|string|in:news,regular,strategy,regular,slider'
            ]);

        if($validate->fails()){
         return $this->requiredField($validate->errors()->first());   }
        try{
        $matching=Matching::where('uuid',$uuid)->first(); 
        if(!$matching)
       {  return $this->notFoundResponse('not found match'); }
       
        $image='';
       if($request->image)
         { $image=$this->uploadImagePublic2($request,'informations','image');}

         $uuidI=Str::uuid();
         $matching=$matching->information()->save(new Information([
          'uuid'=>$uuidI,
          'title'=>$request->title,
          'content'=>$request->content,
          'image'=>$image,
          'reads'=>1,
          'type'=>$request->type
           ]));
           return $this->apiResponse($matching);
        }catch (\Throwable $th) {
              
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
      
    }

    public function informationClub( Request $request,$uuid)
    {
        $validate = Validator::make($request->all(),[
        
        'title' => 'string|min:20|max:100|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'content' => 'required|string|min:20|max:1000',
        'image' => 'required|file|mimes:jpg,png,jpeg,jfif|max:2000',
        "type"=>'required|string|in:news,regular,strategy,regular,slider'
        ]);
        if($validate->fails()){
         return $this->requiredField($validate->errors()->first());    
         }

        try{
        $club=Club::where('uuid',$uuid)->first(); 
        if($club)
        {
         
         $image='';
         if($request->image)
    {  $image=$this->uploadImagePublic2($request,'informations','image');}
        $uuidI=Str::uuid();
        $club=$club->information()->save(new Information([
        'uuid'=>$uuidI,
        'title'=>$request->title,
        'content'=>$request->content,
        'image'=>$image,
        'reads'=>1,
        'type'=>$request->type
           ]));
        return $this->apiResponse($club);
    }
        else{
        return $this->notFoundResponse('not found club');
        }
    } catch (\Throwable $th) {
              
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }




    public function informationSession( Request $request,$uuid)
    {
    $validate = Validator::make($request->all(),[
        
    'title' => 'string|min:20|max:100|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
    'content' => 'required|string|min:20|max:1000',
    'image' => 'required|file|mimes:jpg,png,jpeg,jfif|max:2000',
    "type"=>'required|string|in:news,regular,strategy,regular,slider'
     ]);
    if($validate->fails()){
    return $this->requiredField($validate->errors()->first());    
         }
    try{
    $session=Session::where('uuid',$uuid)->first(); 
     if($session)
    {
   
     $image='';
    if($request->image)
    {  $image=$this->uploadImagePublic2($request,'informations','image');}
    $uuidI=Str::uuid();
    $session=$session->information()->save(new Information([
    'uuid'=>$uuidI,
    'title'=>$request->title,
    'content'=>$request->content,
    'image'=>$image,
    'reads'=>0,
    'type'=>$request->type
     ]));
    return $this->apiResponse($session);
    }
     else{
    return $this->notFoundResponse('not found session');
     }
    } catch (\Throwable $th) {
              
     return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function show( $uuid)
    { try{
        $information=Information::where('uuid',$uuid)->first();
        if(!$information){
        return $this->notFoundResponse('not found information');
         }
         else{
         $matching=InformationResource::make($information);
         return $this->apiResponse($information);
         }
        } catch (\Throwable $th) {
              
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $uuid)
    {
        $validate = Validator::make($request->all(),[
            'title' => 'string|min:20|max:100',
            'content' => '|string|min:20|max:1000',
            'image_file' => '|file|mimes:jpg,png,jpeg,jfif|max:2000',
            "type"=>'|string|in:news,regular,strategy,regular,slider'

            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
                $image='';
                $information=Information::where('uuid',$uuid)->first();
                $information->update($request->all());
                if($request->image_file)
                { $this->deleteFile($information->image);
                $image=$this->uploadImagePublic2($request,'informations','image_file');
                $information->image=$image;
                $information->save();
                }
                return $this->apiResponse('updated successfully!');
              } catch (\Throwable $th) {
              
                return $this->apiResponse(null,false,$th->getMessage(),500);
                }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Information  $information
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    { try{
        $information=Information::where('uuid',$uuid)->first(); 
        if(!$information)
        {
        return $this->notFoundResponse("not found");
        }
        else   {
        $club->delete();
        return $this->apiResponse("deleted successfully!");
    
     }
    } catch (\Throwable $th) {
              
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }
}
