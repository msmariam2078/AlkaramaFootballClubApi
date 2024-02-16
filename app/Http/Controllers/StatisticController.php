<?php

namespace App\Http\Controllers;

use App\Models\Statistic;
use Illuminate\Http\Request;
use App\Models\Matching;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\StatisticResource;
use App\Http\Traits\GeneralTrait;

class StatisticController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uuid)
    {
        $matching=Matching::where('uuid',$uuid)->first();
        if(!$matching)
        {
        return $this->notFoundResponse(['not found match']);
        }
        $stat=Statistic::where('matching_id',$matching->id)->get();
       $stat=StatisticResource::collection($stat);
      return $this->apiResponse($stat);
    }

    public function show($uuid)
    {
        $stat=Statistic::where('uuid',$uuid)->first();
        if(!$stat)
        {
        return $this->notFoundResponse(['not found statistic']);
        }
 
       $stat=StatisticResource::make($stat);
      return $this->apiResponse($stat);
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
        $validate = Validator::make([
           'name'=>$request->name, 
           'club1'=>$request->club1,
           'club2'=>$request->club2,  ],[
           
            'name' => 'required|string|in:scores,scores_in_net,yellow_card,mistakes,offsides,corners',
            'club1'=>'required|integer|min:0|max:10',
            'club2' => 'required|integer|min:0|max:10',
           
        ]);
        if($validate->fails()){
            return $this->requiredField($validate->errors()->first()); }
        try{
        $matching=Matching::where('uuid',$uuid)->where('status','finished')->first();
        if(!$matching)
        {return $this->notFoundResponse(['not found match']);}
       $existStat=Statistic::where('matching_id',$matching->id)
       ->where('name',$request->name)->first();
       if($existStat)
       {
        return $this->unAuthorizeResponse();
       }
    
        $uuidS=Str::uuid();
        $value['club1']=$request->club1;
        $value['club2']=$request->club2;
        $stat=Statistic::create(['uuid'=>$uuidS,
        'name'=>$request->name,
        'value'=>$value,
        'matching_id'=>$matching->id
        ]); 
        return $this->apiResponse($stat);
   
    }
       catch (\Throwable $th) {
      
    return $this->apiResponse(null,false,$th->getMessage(),500);
    }

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $uuid)
    {
        $validate = Validator::make(['uuid'=>$uuid,
        'name'=>$request->name, 
        'club1'=>$request->club1,
        'club2'=>$request->club2,  ],[
         'uuid'=>'string||exists:statistics,uuid',
         'club1'=>'min:0|max:10',
         'club2' => 'min:0|max:10',
        
     ]);
     if($validate->fails()){
         return $this->requiredField($validate->errors()->first()); }
     
        try{
        $statistic=Statistic::where('uuid',$uuid)->first();
        if(!$statistic)
        {
         return $this->notFoundResponse(['not found match']);
        }
       
        $request->club1?
        $value['club1']=$request->club1:
        $value['club1']=$statistic->value['club1'];

        $request->club2?
        $value['club2']=$request->club2:
        $value['club2']=$statistic->value['club2'];

         $statistic->update([
        
         'value'=>$value,
        
         ]); 
         return $this->apiResponse(['update successfully!']);
    
       } catch (\Throwable $th) {
      
    return $this->apiResponse(null,false,$th->getMessage(),500);
    }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function destroy( $uuid)
    {
        try{
            $statistic=Statistic::where('uuid',$uuid)->first(); 
            if(!$statistic)
            {
            return $this->notFoundResponse(["not found"]);
            }
            else   {
            $statistic->delete();
            return $this->apiResponse(["deleted successfully!"]);
        
         }
        } catch (\Throwable $th) {
                  
            return $this->apiResponse(null,false,$th->getMessage(),500);
            
    }
}
}
