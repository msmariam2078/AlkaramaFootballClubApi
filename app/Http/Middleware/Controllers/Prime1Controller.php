<?php

namespace App\Http\Controllers;

use App\Models\Prime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Sport;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Str;
use App\Http\Resources\SportResource;
use App\Http\Resources\PrimeResource;

class PrimeController extends Controller
{
    use GeneralTrait ,FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
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
    {   //echo 'klk';
        $validate = Validator::make($request->all(),[
            //'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
            'name' => 'required|string|max:255',
            'descreption' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpg,png,jpeg,jfif|max:2000',
            'type' => 'required|string|in:personal,club',
            'session_uuid' => 'required|string|exists:sessions,uuid',
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
            $sport_id=Sport::where('uuid',$request->input('sport_uuid'))->value('id');
            $prime=Prime::firstOrCreate( [
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'descreption' => $request->descreption,
            'image' => $image,
            'type' => $request->type,
            'session_id' => $session_id,
            'sport_id' => $sport_id
                    ]);
            $prime =new PrimeResource($prime);
            return $this->apiResponse($prime);
                } else{
                    return  $this->apiResponse(null, false,'Failed to upload image',500);
            
                }  } catch (\Throwable $th) {
                  
                    return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prime  $prime
     * @return \Illuminate\Http\Response
     */
    public function show(Prime $prime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prime  $prime
     * @return \Illuminate\Http\Response
     */
    public function edit(Prime $prime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prime  $prime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $uuid)
    {
        $validate = Validator::make($request->all(),[
            //'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
            'name' => 'required|string|max:255',
            'descreption' => 'required|string|max:255',
            'prime_image' => 'required|file|mimes:jpg,png,jpeg,jfif',
            'type' => 'required|string|in:personal,club',
            'session_uuid' => 'required|string|exists:sessions,uuid',
            'sport_uuid' => 'required|string|exists:sports,uuid'
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{$image='';
                $prime=Prime::where('uuid',$uuid)->first();
                $prime->update($request->all());
                if($request->prime_image)
                {  $this->deleteFile($prime->image);
                $image=$this->uploadImagePublic2($request,'primes','prime_image');
                $prime->image=$image;
                $prime->save();
                return  $this->apiResponse( 'updated successfuly');
                }
              } catch (\Throwable $th) {
              
                return $this->apiResponse(null,false,$th->getMessage(),500);
               }
            
    }

    public function showBytype(Request $request)
    {
    $validate = Validator::make($request->all(),[
    'type' => 'required|string|in:personal,club',
    'sport_uuid' => 'required|string|exists:sports,uuid',]);

    if($validate->fails()){
    return $this->requiredField($validate->errors()->first()); }
    try{
    $sport_id=Sport::where('uuid',$request->input('sport_uuid'))->value('id');
    $primes = Prime::where('type',$request->type)->where('session_id',$session_id)->get();
    if( $primes->isEmpty()){
    return $this->notFoundResponse('notfound primes');
    }

    else{

    $primes = PrimeResource::collection($primes); 
    return $this->apiResponse($primes);
     }
    }
    catch (\Throwable $th) {
   
 return $this->apiResponse(null,false,$th->getMessage(),500);
 }}
   
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
         return $this->notFoundResponse('notfound');
        }
        else{
        $prime->delete();
        return $this->apiResponse("succssifull delete",true,null,201);
     }
    }
}
