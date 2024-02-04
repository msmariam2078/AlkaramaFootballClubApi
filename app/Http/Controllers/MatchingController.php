<?php

namespace App\Http\Controllers;

use App\Models\Matching;
use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Session;
use App\Models\Sport;
use Illuminate\Support\Str;
use App\Http\Traits\GeneralTrait;
use App\Http\Resources\MatchingsResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploader;
class MatchingController extends Controller
{   use GeneralTrait ,FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matchings=Matching::all();
        if($matchings->isEmpty()){
        return $this->notFoundResponse('not found matchs');
         }
         else{
    
         $matchings=MatchingsResource::collection($matchings);
         return $this->apiResponse($matchings);
         }
    }

    
    public function indexByStatus(Request $request)
    {   $validate = Validator::make($request->all(),[
        
        'status' => 'required|string|in:finished,not_started',
    ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first()); }

        $matchings=Matching::where('status',$request->status);
        if($matchings->isEmpty()){
        return $this->notFoundResponse('not found matchs');
         }
         else{
    
         $matchings=MatchingsResource::collection($matchings);
         return $this->apiResponse($matchings);
         }
    }
    public function indexByDate(Request $request)
    {
    $validate = Validator::make($request->all(),[
        
     'when' => 'required|date',
    ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first()); }
        $matchings=Matching::where('when',$request->when)->get();
        if($matchings->isEmpty()){
        return $this->notFoundResponse('not found matchs');
         }
         else{
    
         $matchings=MatchingsResource::collection($matchings);
         return $this->apiResponse($matchings);
         }
    }


    public function show( $uuid)
    {
        $matching=Matching::where('uuid',$uuid)->first();
        if(!$matching){
        return $this->notFoundResponse('not found match');
         }
         else{
    
         $matching=MatchingsResource::make($matching);
         return $this->apiResponse($matching);
         }
    }

   
    public function store(Request $request)
    {
    try {
        $validate = Validator::make($request->all(),[
        'when' => 'required|date',
        'status'=>'required|string|in:not_started,finished',
        'plan_image' => 'file|mimes:jpg,png,jpeg,jfif',
        'channel'=>'required|string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'round'=>'required|string',
        'play_ground'=>'required|string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'session_uuid'=>'required|string|exists:sessions,uuid',
        'club1_uuid'=>'required|string|exists:clubs,uuid',
        'club2_uuid'=>'required|string|exists:clubs,uuid'
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        }
        ($request->plan_image)?$image=$this->uploadImagePublic2($request,'match','plan_image'):$image='';
        
       
        $uuid=Str::uuid();
        $session_id=Session::where('uuid',$request->input('session_uuid'))->value('id');
        $club1_id=Club::where('uuid',$request->input('club1_uuid'))->value('id');
        $club2_id=Club::where('uuid',$request->input('club2_uuid'))->value('id');
        $matching=Matching::firstOrCreate( ['uuid'=>$uuid,
        'when' => $request->when,
        'status'=>$request->status,
        'plan_image' => $image,
        'channel'=>$request->channel,
        'round'=>$request->round,
        'play_ground'=>$request->play_ground,
        'session_id'=>$session_id,
        'club1_id'=> $club1_id,
        'club2_id'=> $club2_id
    
    ]);
        return $this->apiResponse($matching);
    
       


     } catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }

   
    
    public function update(Request $request,$uuid)
        {  $validate = Validator::make($request->all(),[
            'when' => 'date',
            'status'=>'string|in:not_started,finished',
            'image' => 'file|mimes:jpg,png,jpeg,jfif',
            'channel'=>'string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
            'round'=>'string',
            'play_ground'=>'string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        
        
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
            $image='';
            $matching=Matching::where('uuid',$uuid)->first();
            $matching->update($request->all());
            if($request->image)
            { $this->deleteFile($matching->plan_image);
            $image=$this->uploadImagePublic2($request,'match','image');
            $matching->plan_image=$image;
            $matching->save();
            }
         
            
        
        
       
        
        
        } catch (\Throwable $th) {
          
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
        }
        









    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Matche  $matche
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    {
        $matching=Matching::where('uuid',$uuid)->first(); 
        if($matching)
       { $matching->delete();
        return $this->apiResponse("deleted successfuly!");}
        else{
        return $this->notFoundResponse('not found match');
        }
    }
}
