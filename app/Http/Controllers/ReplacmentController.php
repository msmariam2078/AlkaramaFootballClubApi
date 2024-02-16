<?php

namespace App\Http\Controllers;

use App\Models\Replacment;

use App\Models\Matching;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Player;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ReplacmentResource;
use App\Http\Traits\GeneralTrait;

class ReplacmentController extends Controller
{   use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexByMatch($uuid)
    {     
        try{
        $matching=Matching::where('uuid',$uuid)->first();
        if(!$matching)
        {
        return $this->notFoundResponse(['not found match']);
        }
        $reps=Replacment::where('matching_id',$matching->id)->get();
        $reps=ReplacmentResource::collection($reps);
        return $this->apiResponse($reps);
        }catch (\Throwable $th) {
          
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
    $validate = Validator::make(['inplayer_uuid'=>$request->inplayer_uuid,
    'outplayer_uuid'=>$request->outplayer_uuid,],
    [
        'inplayer_uuid' => 'required|string|exists:players,uuid',
        'outplayer_uuid' => 'required|string|exists:players,uuid',
       
    ]);
    if($validate->fails()){
    return $this->requiredField($validate->errors()->first());    
    }   
    try{
    $uuidR=Str::uuid();
    $matching=Matching::where('uuid',$uuid)->first();
    if(!$matching)
    {
     return $this->notFoundResponse(['not found']);
    }
    $inplayer=Player::where('uuid',$request->inplayer_uuid)->first();
    $outplayer=Player::where('uuid',$request->outplayer_uuid)->first();
   
    $beanch_player= Plan::where('matching_id',$matching->id)
    ->where('player_id',$inplayer->id)
    ->where('status','beanch')->first();
    if($beanch_player&& $inplayer->id!=$outplayer->id)
    {
    $rep=Replacment::create(['uuid'=>$uuidR,
    'inplayer_id'=>$inplayer->id,
    'outplayer_id'=>$outplayer->id,
    'matching_id'=>$matching->id
    ]);
     return $this->apiResponse($rep);
    }else {
    return $this->unAuthorizeResponse(['cannot add this replacment']);
    }}
    catch (\Throwable $th) {
          
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Replacment  $replacment
     * @return \Illuminate\Http\Response
     */
    public function show( $uuid)
    {  try{
       $rep=Replacment::where('uuid',$uuid)->first();
      if($rep)
      {
        $rep=ReplacmentResource::make($rep);
        return $this->apiResponse($rep);
      }
      else{
        return $this->notFoundResponse(['this replacment not found']);
      }}
      catch (\Throwable $th) {
    
          return $this->apiResponse(null,false,$th->getMessage(),500);
          }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Replacment  $replacment
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Replacment  $replacment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $uuid)
    {
        $validate = Validator::make($request->all(),
        [
            'inplayer_uuid' => 'string|exists:players,uuid',
            'outplayer_uuid' => 'string|exists:players,uuid',
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        } 
      try{
           
          
        $rep=Replacment::where('uuid',$uuid)->first();
        if(!$rep)
        {
         return $this->notFoundResponse('not found');
        }
    
        $inplayer=Player::where('uuid',$request->inplayer_uuid)->first();
        $outplayer=Player::where('uuid',$request->outplayer_uuid)->first(); 
      
       
        if($inplayer)
       {$beanch=Plan::where('player_id',$inplayer->id)
              ->where('matching_id',$rep->matching_id)
              ->where('status','beanch')
              ->first();
       if(!$beanch)
       {
        return $this->unAuthorizeResponse(['cannot add this replacment']);
       }     
            
            
 }
        if($inplayer&&$outplayer&&$inplayer->id!=$outplayer->id)
        {
            return $this->unAuthorizeResponse(['cannot add this replacment']);
        }

      $inplayer?$rep->inplayer_id=$inplayer->id:$rep->inplayer_id;
      $outplayer?$rep->outplayer_id=$outplayer->id:$rep->outplayer_id;
      $rep->save();

         return $this->apiResponse(['updated successfully!']);
    }
        catch (\Throwable $th) {
      
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Replacment  $replacment
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    {   try{
        $rep=Replacment::where('uuid',$uuid)->first();
       
        if(!$rep)
        {   return $this->notFoundResponse(['cannot delete this replacment']); }
        else{
            $rep->delete();

            return $this->apiResponse(['deleted successfully!']);
        }
    }
    catch (\Throwable $th) {
  
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }}
