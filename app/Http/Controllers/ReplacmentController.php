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
    public function index()
    {
        $reps=Replacment::all();
        if($reps->isEmpty()){
            return $this->notFoundResponse('not found replacements');
             }
             else{
        
             $reps=ReplacmentResource::collection($reps);
             return $this->apiResponse($reps);
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
    'outplayer_uuid'=>$request->outplayer_uuid,'uuid'=>$uuid],
    [
        'inplayer_uuid' => 'required|string|exists:players,uuid',
        'outplayer_uuid' => 'required|string|exists:players,uuid',
        'uuid'=>'required|string|exists:matchings,uuid'
    ]);
    if($validate->fails()){
    return $this->requiredField($validate->errors()->first());    
    }   
    $uuidR=Str::uuid();
    $matching=Matching::where('uuid',$uuid)->first();
    $inplayer=Player::where('uuid',$request->inplayer_uuid)->first();
    $outplayer=Player::where('uuid',$request->outplayer_uuid)->first();
   
    $beanch_players= Plan::where('matching_id',$matching->id)->where('status','beanch')->pluck('player_id')->toArray();

    $beanch=in_array($inplayer->id,$beanch_players);
    if($beanch&& $inplayer->id!=$outplayer->id)
    {
    $rep=Replacment::create(['uuid'=>$uuidR,
    'inplayer_id'=>$inplayer->id,
    'outplayer_id'=>$outplayer->id,
    'matching_id'=>$matching->id
    ]);
     return $this->apiResponse($rep);
    }else {
    return $this->notFoundResponse('cannot add this replacment');
    }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Replacment  $replacment
     * @return \Illuminate\Http\Response
     */
    public function show( $uuid)
    {
       $rep=Replacment::where('uuid',$uuid)->first();
      if($rep)
      {
        $rep=ReplacmentResource::make($rep);
        return $this->apiResponse($rep);
      }
      else{
        return $this->notFoundResponse('this replacment not found');
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
        $validate = Validator::make(['inplayer_uuid'=>$request->inplayer_uuid,
        'outplayer_uuid'=>$request->outplayer_uuid,'uuid'=>$uuid],
        [
            'inplayer_uuid' => 'required|string|exists:players,uuid',
            'outplayer_uuid' => 'required|string|exists:players,uuid',
            'uuid'=>'required|string|exists:replacments,uuid'
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        } 
        $rep=Replacment::where('uuid',$uuid)->first();
        $inplayer=Player::where('uuid',$request->inplayer_uuid)->first();
        $outplayer=Player::where('uuid',$request->outplayer_uuid)->first(); 
        $beanch_players= Plan::where('matching_id',$rep->matching_id)->where('status','beanch')->pluck('player_id')->toArray();

        $beanch=in_array($inplayer->id,$beanch_players);
        if($beanch&& $inplayer->id!=$outplayer->id)
        {
        $rep->update([
        'inplayer_id'=>$inplayer->id,
        'outplayer_id'=>$outplayer->id,
       
        ]);
         return $this->apiResponse('updated successfully!');
        }else {
        return $this->notFoundResponse('cannot update this replacment');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Replacment  $replacment
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    {
        $rep=Replacment::where('uuid',$uuid)->first();
       
        if(!$rep)
        {   return $this->notFoundResponse('cannot delete this replacment'); }
        else{
            $rep->delete();

            return $this->apiResponse('deleted successfully!');
        }
    }
}
