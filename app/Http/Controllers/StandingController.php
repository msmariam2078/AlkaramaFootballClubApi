<?php

namespace App\Http\Controllers;
use App\Models\Session;
use App\Models\Club;
use App\Models\Matching;
use App\Models\Standing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Traits\GeneralTrait;
use App\Http\Resources\StandingResource;
use Illuminate\Support\Facades\Validator;

class StandingController extends Controller
{
    use GeneralTrait;

  
   
    public function index(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'session_name'=>'string|exists:sessions,name',
            'date'=>'date',
     
        
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
        $session=Session::where('name',$request->session_name)
                        ->where('end_date',$request->date)
                        ->first();
                        
        if(!$session)
        {
            return $this->notFoundResponse($session); 
        }
        $stand=Standing::where('session_id',$session->id)->orderByDesc('points')->get();
        $standing= StandingResource::collection($stand);

        return $this->apiResponse($standing);  
    } catch (\Throwable $th) {
          
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
       
    //     $club=Club::find(1);   
    //     $club_match=$club->matchesAsClub1;
    //     $count=0;
    //     foreach($club_match as $club)
    //   { 
    //     $club=$club->where('status','finished')->get();
    //    if($club)
    //    $count=$count+1;
           
    //     }
    //     return  $count;
      
    //   }

       


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
       
            $validate = Validator::make($request->all(),[
            'win'=>'required|integer|min:0|max:10',
            'lose'=>'required|integer|min:0|max:10',
            'draw'=>'required|integer|min:0|max:10',
            'balanced'=>'required|integer|min:0|max:10',
            'points'=>'required|integer|min:0|max:40',
            'play'=>'required|integer|min:1|max:40',
            'session_uuid'=>'required|string|exists:sessions,uuid',
            'club_uuid'=>'required|string|exists:clubs,uuid'
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try {
     
            $session=Session::where('uuid',$request->input('session_uuid'))->value('id');
            $club=Club::where('uuid',$request->input('club_uuid'))->value('id');
            $existClub=Standing::where('session_id')->where('club_id')->first();
            if($existClub)
            {
                return $this->unAuthorizeResponse();
            }
            $standing=Standing::firstOrCreate( ['uuid'=>Str::uuid(),
            'win' => $request->win,
            'lose' => $request->lose ,
            'draw' =>$request->draw ,
             '+/-' => $request->balanced,
            "points"=>$request->points,
            'play' =>$request->play,
            "session_id"=>$session,
            "club_id"=> $club
            ]);
           
            $standing= StandingResource::make($standing);
            return $this->apiResponse($standing);
        
           
         
         } catch (\Throwable $th) {
          
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
        }
   
    public function update(Request $request,$uuid)
    {
   
            $validate = Validator::make($request->all(),[
            'win'=>'integer',
            'lose'=>'integer',
            'draw'=>'integer',
            'balanced'=>'integer',
            'points'=>'integer',
            'play'=>'integer|min:1',
        
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
            $standing=Standing::where('uuid',$uuid)->first();
            
            if (!$standing)
            { return $this->notFoundResponse($standing);
             
             }
            $standing=$standing->update($request->all());
            return $this->apiResponse(["updatet successfully!"]);
               
          }catch (\Throwable $th) {
            
             return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }          


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Standing  $standing
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {

        $standing = Standing::where('uuid',$uuid)->first();

        if ($standing) {
            $standing->delete();
            return $this->apiResponse(["succssifull delete"]);}
        else {
         return $this->notFoundResponse(['not found standing']);
        
        }




    }
}
