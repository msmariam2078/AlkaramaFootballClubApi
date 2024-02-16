<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Resources\SessionResource;
use App\Http\Traits\GeneralTrait;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;

class SessionController extends Controller
{   use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessions=Session::all();
        $sessions=SessionResource::collection($sessions);
         return $this->apiResponse($sessions);
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
            'name' => 'string|min:2|max:20|required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
                    ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
            $existSession=Session::where('name',$request->name)
                           ->where('start_date',$request->start_date)
                           ->first();

            if($existSession){
                return $this->unAuthorizeResponse(); 
            }
          
            $session = Session::firstOrCreate( [
            'uuid' => Str::uuid(),
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
                    ]);
            $session = SessionResource::make($session);
            return $this->apiResponse($session);
            
                }   catch (\Throwable $th) {
                  
                    return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function show( $uuid)
    {
        try{
            $session= Session::where('uuid',$uuid)->first();
           
            if(!$session)
            {
                return $this->apiResponse(null,false,['not found'],404); 
            }
      
            $session=SessionResource::make($session);
            return $this->apiResponse($session); 

           } catch (\Throwable $th) {
                  
           return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'string|min:2|max:20',
            'start_date' => 'date',
            'end_date' => 'date|after:start_date',
              ]);
              if($validate->fails()){
              return $this->requiredField($validate->errors()->first());    
              }
              try{
             
                  $session = Session::where('uuid',$uuid)->first();
                  if(!$session)
                  {return  $this->apiResponse( null,false,['not found'],404);}
                  $session->update($request->all());
                  return  $this->apiResponse( ['updated successfuly']);
                } catch (\Throwable $th) {
                
                  return $this->apiResponse(null,false,$th->getMessage(),500);
                 }
              
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Session  $session
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $session = Session::where('uuid',$uuid)->first(); 
        if(!$session)
        {
         return $this->notFoundResponse(['notfound']);
        }
        else{
        $session->delete();
        return $this->apiResponse(["succssifull delete"],true,null,201);
     }
    }
}
