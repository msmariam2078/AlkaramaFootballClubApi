<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Player;
use App\Models\Matching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploader;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Str;
use App\Http\Resources\PlanResource;
use App\Http\Resources\PlayerResource;

class PlanController extends Controller
{
    use GeneralTrait ,FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByMatch($uuid)
    {
        try{
            $matching= Matching::where('uuid',$uuid)->first();
           
            if(!$matching)
            {
                return $this->apiResponse(null,false,'not found',404); 
            }
            $plans=Plan::where('matching_id',$matching->id)->get();
            $plans=PlanResource::collection($plans);
            return $this->apiResponse($plans); 

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
    public function store(Request $request,$uuid)
    {
        $validate = Validator::make($request->all(),[
            //'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
            'player_uuid' => 'required|string|exists:players,uuid',
            'status' => 'required|string|in:main,beanch',
                    ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
            $matching= Matching::where('uuid',$uuid)->first();
           
            if(!$matching)
            {
                return $this->apiResponse(null,false,['not found'],404); 
            }
            $player_id = Player::where('uuid',$request->input('player_uuid'))->value('id');
            $existplan=Plan::where('player_id',$player_id)
                           ->where('matching_id',$matching->id)
                           ->first();

            if($existplan){
                return $this->unAuthorizeResponse(); 
            }
          
            $plan = Plan::firstOrCreate( [
            'uuid' => Str::uuid(),
            'matching_id' => $matching->id,
            'player_id' => $player_id,
            'status' => $request->status,
                    ]);
            $plan = PlanResource::make($plan);
            return $this->apiResponse($plan);
            
                }   catch (\Throwable $th) {
                  
                    return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show( $uuid)
    {
        
        try{
            $plan= Plan::where('uuid',$uuid)->first();
           
            if(!$plan)
            {
                return $this->apiResponse(null,false,['not found'],404); 
            }
      
            $plan=PlanResource::make($plan);
            return $this->apiResponse($plan); 

           } catch (\Throwable $th) {
                  
           return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
    
        $validate = Validator::make($request->all(),[
          'status' => 'string|in:main,beanch',
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
                $plan = Plan::where('uuid',$uuid)->first();
                if(!$plan)
                {return  $this->apiResponse( null,false,['not found'],404);}
                $plan->update($request->all());
                return  $this->apiResponse( ['updated successfuly']);
              } catch (\Throwable $th) {
              
                return $this->apiResponse(null,false,$th->getMessage(),500);
               }
            
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid )
    {
        $plan = Plan::where('uuid',$uuid)->first(); 
        if(!$plan)
        {
         return $this->notFoundResponse(['notfound']);
        }
        else{
        $plan->delete();
        return $this->apiResponse(["succssifull delete"],true,null,201);
     }
    }
}
