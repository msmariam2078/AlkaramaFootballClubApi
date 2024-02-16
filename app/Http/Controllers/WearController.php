<?php

namespace App\Http\Controllers;


use App\Models\Wear;
use App\Models\Sport;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploader;
use App\Http\Resources\WearResource;
use Illuminate\Support\Str;
class WearController extends Controller
{
 
use GeneralTrait, FileUploader;
public function index(){
    $wears=Wear::all();
    $wears=WearResource::collection($wears);
     return $this->apiResponse($wears);
     }



     public function showBySession(Request $request)
     {
         $validate = Validator::make($request->all(),[
             'session' => 'required|string|exists:sessions,uuid',
          ]);
         if($validate->fails()){
             return $this->requiredField($validate->errors()->first());    
             }
      try{
     $session=Session::where('uuid',$request->session)->first();
     dd($session);
     if(!$session)
     {
      return    $this->apiResponse(null,false,['not found']);

     }
      $wears=Wear::where('session_id',$session->id)->get();
 
     if(!$wears)
     {
         return    $this->apiResponse(null,false,['not found']);
     }
     $wears=WearResource::collection($wears); 
     //dd($wears);
   return $this->apiResponse($wears);
      }catch (\Throwable $th) {
       
         return $this->apiResponse(null,false,$th->getMessage(),500);
         }
 
      }




      public function store(Request $request)
      {
          
          $validate = Validator::make($request->all(),[
         
          'session_uuid' => 'required|string|exists:sessions,uuid',
          'image' => 'required|file|mimes:jpg,png,jpeg,jfif|max:2000',
          "sport_uuid"=>'required|string|exists:sports,uuid'
          ]);
          if($validate->fails()){
          return $this->requiredField($validate->errors()->first());    
          }
          try{
          $image=$this->uploadImagePublic2($request,'wears','image');
          if(!$image)
          {
          return  $this->apiResponse(null, false,['Failed to upload image'],500); 
           }
  
          else{
          
          $sport=Sport::where('uuid',$request->input('sport_uuid'))->first();
          $session=Session::where('uuid',$request->input('session_uuid'))->first();
   
        if(!$sport||!$session)
        {
          return  $this->apiResponse(null, false,['not found'],404);
        }
          $uuid=Str::uuid();
          $wear=Wear::firstOrCreate(['uuid'=>$uuid,
          'sport_id'=>$sport->id,
      
          'image'=>$image,
          'session_id'=>$session->id,
  
      ]);
          $wear=WearResource::make($wear); 
          return $this->apiResponse($wear) ;  
          
         
  
  
      }  } catch (\Throwable $th) {
        
          return $this->apiResponse(null,false,$th->getMessage(),500);
          }
      }



      public function update(Request $request,$uuid)
      {  $validate = Validator::make($request->all(),[
       
  
          'wear_image' => 'file|mimes:jpg,png,jpeg,jfif|max:2000',
      
          ]);
          if($validate->fails()){
          return $this->requiredField($validate->errors()->first());    
          }
          try{
          $wear=Wear::where('uuid',$uuid)->first();
          if(!$wear)
          {
           return $this->notFoundResponse(['not found replacements']);
  
          }
        
          $wear->update($request->all());
         if($request->wear_image) {
          $this->deleteFile($wear->image);
          $image=$this->uploadImagePublic2($request,'wears','wear_image');
          if(!$image){
          return  $this->apiResponse(null, false,['Failed to upload image'],500);
          }
        
          $wear->image=$image;
            $wear->save();}
            return  $this->apiResponse(['uploaded successfuly!']);
          }catch (\Throwable $th) {
      
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
}



       public function destroy( $uuid)
        {   
       $wear=Wear::where('uuid',$uuid); 
       if(!$wear)
       {
       return $this->notFoundResponse(["not found club"]);
       }
       else{
       $wear->delete();
       return $this->apiResponse(["deleted successfully!"]);
    }
}  }