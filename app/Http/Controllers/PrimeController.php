<?php

namespace App\Http\Controllers;
use App\Models\Prime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Session;
use App\Models\Sport;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Str;
use App\Http\Resources\SportResource;
use App\Http\Resources\PrimeResource;

class PrimeController extends Controller
{
    use GeneralTrait ,FileUploader;
   
    public function show( $uuid)
    {
        
        try{
            $prime= Prime::where('uuid',$uuid)->first();
           
            if(!$prime)
            {
                return $this->apiResponse(null,false,['not found'],404); 
            }
      
            $prime=PrimeResource::make($prime);
            return $this->apiResponse($prime); 

           } catch (\Throwable $th) {
                  
           return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }
   public function index()
   
   {
    try{
        $prime=Prime::all(); 
        $prime= PrimeResource::collection($prime);
        return $this->apiResponse($prime);
  
         }catch (\Throwable $th) {
     
          return $this->apiResponse(null,false,$th->getMessage(),500);
       
          }

   }


    public function showBytype(Request $request)
    {
    $validate = Validator::make($request->all(),[
    'type' => 'required|string|in:personal,club',
    
    ]);

    if($validate->fails()){
    return $this->requiredField($validate->errors()->first()); }
    try{
  
        
    $primes = Prime::where('type',$request->type)->get();
   

    $primes = PrimeResource::collection($primes); 
    return $this->apiResponse($primes);
     
    }
    catch (\Throwable $th) {
   
 return $this->apiResponse(null,false,$th->getMessage(),500);
 }}






    public function store(Request $request)
    {   
        $validate = Validator::make($request->all(),[
            //'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
            'name' => 'required|string|max:255',
            'desc' => 'string|max:1000',
            'image' => 'required|file|mimes:jpg,png,jpeg,jfif',
            'type' => 'required|string|in:personal,club',
            'session_uuid' => 'string|exists:sessions,uuid',
            'sport_uuid' => 'required|string|exists:sports,uuid'
                    ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
             try{
            $image=$this->uploadImagePublic2($request,'primes','image');
            if($image)
            {  
            $session_id=Session::where('uuid',$request->input('session_uuid'))->value('id');
            // dd($session_id);
            $sport_id=Sport::where('uuid',$request->input('sport_uuid'))->value('id');
            // dd($sport_id);
            $prime=Prime::firstOrCreate( [
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'desc' => $request->desc,
            'image' => $image,
            'type' => $request->type,
            'session_id' => $session_id,
            'sport_id' => $sport_id
                    ]);
            // $prime =new PrimeResource($prime);
            // PrimeResource::make($prime);
            return $this->apiResponse(PrimeResource::make($prime));
                } else{
                    return  $this->apiResponse(null, false,['Failed to upload image'],500);
            
                } 
            } catch (\Throwable $th) {
                  
                    return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

   
    public function update(Request $request,  $uuid)
    {
        $validate = Validator::make($request->all(),[
            //'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
            'name' => 'string|max:255',
            'desc' => 'string|max:255',
            'prime_image' => 'file|mimes:jpg,png,jpeg,jfif',
            'type' => 'string|in:personal,club',
            'session_uuid' => 'string|exists:sessions,uuid',
            'sport_uuid' => 'string|exists:sports,uuid'
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
                $image='';
                $prime=Prime::where('uuid',$uuid)->first();
                $prime->update($request->all());
                if($request->prime_image)
                {  $this->deleteFile($prime->image);
                $image=$this->uploadImagePublic2($request,'primes','prime_image');
                if(!$image)
                {
               return  $this->apiResponse(null, false,['Failed to upload image'],500);
                }
                $prime->image=$image;
                $prime->save();
                }
                return  $this->apiResponse( ['updated successfuly']);

              } catch (\Throwable $th) {
              
                return $this->apiResponse(null,false,$th->getMessage(),500);
               }
            
    }

 
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prime  $prime
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid )
    {
        $prime=Prime::where('uuid',$uuid); 
        if(!$prime)
        {
         return $this->notFoundResponse(['not found']);
        }
        else{
        $prime->delete();
        return $this->apiResponse(["succssifull delete"],true,null,201);
     }
    }
}
