<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use  App\Http\Resources\VideoResource;


use App\Models\Club;
use App\Models\Association;
use Illuminate\Support\Str;
use App\Models\Matching;

use App\Http\Traits\FileUploader;
use Illuminate\Support\Facades\Validator;

use App\Http\Traits\GeneralTrait;

class VideoController extends Controller
{    use GeneralTrait,FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
  public function clubVideo(Request $request,$uuid)
  {
       $validate = Validator::make($request->all(),[
        
      
        'url' => 'required|string|unique:videos,url',
        'desc' => 'string|max:1000',
   
       
        ]);
        if($validate->fails()){
         return $this->requiredField($validate->errors()->first());    
         }

        try{
        $club=Club::where('uuid',$uuid)->first(); 
        if($club )
        {
         $club=$club->video()->save(new Video([
        'uuid'=>Str::uuid(),
        'desc'=>$request->desc,
        'url'=>$request->url]));
        $club=VideoResource::make($club);
        return $this->apiResponse($club);
        }
        else{
        return $this->notFoundResponse(['not found club']);
        }
    } catch (\Throwable $th) {
              
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }

  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function matchVideo(Request $request,$uuid)
  {
       $validate = Validator::make($request->all(),[
        
      
        'url' => 'required|string|unique:videos,url',
        'desc' => 'string|max:1000',
   
       
        ]);
        if($validate->fails()){
         return $this->requiredField($validate->errors()->first());    
         }

        try{
        $matching=Matching::where('uuid',$uuid)->first(); 
        if($matching )
        {
         $matching=$matching->video()->save(new Video([
        'uuid'=>Str::uuid(),
        'desc'=>$request->desc,
        'url'=>$request->url]));
        $matching=VideoResource::make($matching);
        return $this->apiResponse($matching);
        }
        else{
        return $this->notFoundResponse(['not found match']);
        }
    } catch (\Throwable $th) {
              
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }

  }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function associationVideo(Request $request,$uuid)
  {
       $validate = Validator::make($request->all(),[
        
      
        'url' => 'required|string|unique:videos,url',
        'desc' => 'string|max:1000',
   
       
        ]);
        if($validate->fails()){
         return $this->requiredField($validate->errors()->first());    
         }

        try{
        $association=Association::where('uuid',$uuid)->first(); 
        if($association )
        {
         $association=$association->video()->save(new Video([
        'uuid'=>Str::uuid(),
        'desc'=>$request->desc,
        'url'=>$request->url]));
        $association=VideoResource::make($association);
        return $this->apiResponse($association);
        }
        else{
        return $this->notFoundResponse(['not found association']);
        }
    } catch (\Throwable $th) {
              
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }

  }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $uuid)
    {
        $validate = Validator::make($request->all(),[
            'url' => 'string',
            'desc' => 'max:1000',
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
                
                $video=Video::where('uuid',$uuid)->first();
                if(!$video)
                {
                    return $this->apiResponse(null,false,['not found'],404);
                }
                $video->update($request->all());
              
                return $this->apiResponse(['updated successfully!']);
              } catch (\Throwable $th) {
              
                return $this->apiResponse(null,false,$th->getMessage(),500);
                }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    { try{
        $video=Video::where('uuid',$uuid)->first(); 
        if(!$video)
        {
        return $this->notFoundResponse(["not found"]);
        }
        else   {
        $video->delete();
        return $this->apiResponse(["deleted successfully!"]);
    
     }
    } catch (\Throwable $th) {
              
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }
}
