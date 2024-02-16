<?php
namespace App\Http\Controllers;
use App\Models\Player;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploader;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\PlayerDetailsResource;
class PlayerController extends Controller
{
    use GeneralTrait ,FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      $players=Player::all(); 
     $players= PlayerResource::collection($players);
      return $this->apiResponse($players);
    }

    public function show ($uuid)
    {

      $player=Player::where('uuid',$uuid)->first(); 
      if(!$player)
      {return $this->notFoundResponse(['not found player ']);}
      else{
      $player= PlayerDetailsResource::make($player);} 
      return
       $this->apiResponse($player);
    }




    public function showByplay(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'sport' => 'required|string|exists:sports,uuid',
        'play' => 'required|string', ]);
        if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
     try{
    $sport=Sport::where('uuid',$request->sport)->first();
    if(!$sport)
    {
        return    $this->apiResponse(null,false,['not found']);
    }
    $players=Player::where('play',$request->play)->where('sport_id',$sport->id)->get();
  
   
    $players=PlayerResource::collection($players); 
    return $this->apiResponse($players);
}catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }

     }
   


     public function store(Request $request)
    {   
        
        $validate = Validator::make($request->all(),[
        'name' => 'required|string|min:2|max:20',
        'high' => 'required|integer|min:175|max:190',
        'play' => 'required|string',
        'number' =>'required|integer|unique:players,number|min:1|max:30',
        "born"=>'required|date|before_or_equal:2006-1-1|after_or_equal:1980-1-1',
        'image' => 'required|file|mimes:jpg,png,jpeg,jfif',
        "from"=>'required|string',
        "first_club"=>'required|string',
        "career"=>'array',
        'career.*'=>'required|string',
        'sport_uuid'=>'required|string|exists:sports,uuid'
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        }
        try{
        $image=$this->uploadImagePublic2($request,'players','image');
        if($image)
        {  
        $uuid=Str::uuid();
        $sport=Sport::where('uuid',$request->input('sport_uuid'))->first();
        if(!$sport)
        {
            $this->apiResponse(null, false,['not found'],404); 
        }
        $player=Player::firstOrCreate( ['uuid'=>$uuid,
        'name' => $request->name,
        'high' => $request->high ,
        'play' =>$request->play ,
        'number' =>$request->number,
        "born"=>$request->born,
        'image' =>$image,
        "from"=>$request->from,
        "first_club"=>$request->first_club,
        "career"=>$request->career,
        'sport_id'=>$sport->id]);
        return $this->apiResponse($player);
    } else{
        return  $this->apiResponse(null, false,['Failed to upload image'],500);
       


    }  } catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }

 
   

    public function update(Request $request, $uuid)
    {
        $validate = Validator::make($request->all(),[
     
            'name' => 'string|min:2|max:20',
            'high' => 'integer|min:175|max:190',
            'play' => 'string|in:goal_keeping,attack,defense,midline',
            'number' =>'integer|unique:players,number|min:1|max:11',
            "born"=>'date|before_or_equal:2006-1-1|after_or_equal:1995-1-1',
            'player_image' => 'file|mimes:jpg,png,jpeg,jfif|max:2000',
            "from"=>'string',
            "first_club"=>'string',
            "career"=>'array',
            'career.*'=>'string',
            'sport_uuid'=>'string|exists:sports,uuid'
        
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
            $player=Player::where('uuid',$uuid)->first();
            if(!$player)
            {
             return $this->notFoundResponse(['not found replacements']);
    
            }
            else{
            $player->update($request->all());
            if($request->player_image) {
            $this->deleteFile($player->image);
            $image=$this->uploadImagePublic2($request,'players','player_image');
            if(!$image){
            return  $this->apiResponse(null, false,['Failed to upload image'],500);
            }
            else{
            $player->image=$image;
            $player->save();}
     
            }
       
        return  $this->apiResponse( ['updated successfuly']);
        
        }}
        catch (\Throwable $th) {
          
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }

        




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $player = Player::where('uuid',$uuid)->first();

       if ($player) {
           $player->delete();
           return $this->apiResponse(["succssifull delete"],true,null,201);}
       else {
        return $this->notFoundResponse(['not found']);
       
       }


    }
}
