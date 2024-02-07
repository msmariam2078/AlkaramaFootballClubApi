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
    try{
      $player=Player::where('uuid',$uuid)->first(); 
      if(!$player)
      {return $this->notFoundResponse('not found player ');}
      else{
      $player= PlayerResource::make($player);} 
      return
       $this->apiResponse($player);
    }
    catch (\Throwable $th) {
   
    return $this->apiResponse(null,false,$th->getMessage(),500);
 }
    }




    public function showByplay(Request $request)
    {

    $validate = Validator::make($request->all(),[
        
    'play' => 'required|string|in:goal_keeping,attack,defense,midline',
    'sport_uuid' =>'required|string|exists:sports,uuid']);
    if($validate->fails()){
    return $this->requiredField($validate->errors()->first()); }
    try{

    $players=Player::where('play',$request->play)->where('sport_uuid',$request->sport_uuid)->get();
    $players=PlayerResource::collection($players); 
    return $this->apiResponse($players);
    }
    catch (\Throwable $th) {
   
 return $this->apiResponse(null,false,$th->getMessage(),500);
 }}
   


     public function store(Request $request)
    {   
        
        $validate = Validator::make($request->all(),[
        'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'high' => 'required|integer|min:170|max:190',
        'play' => 'required|string|in:goal_keeping,attack,defense,midline',
        'number' =>'required|integer|unique:players,number|min:1|max:11',
        "born"=>'required|date|before_or_equal:2006-1-1|after_or_equal:1995-1-1',
        'image' => 'required|file|mimes:jpg,png,jpeg,jfif|max:2000',
        "from"=>'required|string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        "first_club"=>'required|string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        "career"=>'required|array',
        'career.*'=>'required|min:10|max:50|string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
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
        $sport_id=Sport::where('uuid',$request->input('sport_uuid'))->value('id');
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
        'sport_id'=>$sport_id]);
        $player=PlayerResource::make($player); 
        return $this->apiResponse($player);
    } else{
        return  $this->apiResponse(null, false,'Failed to upload image',500);
       


    }  } catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }

 
   

    public function update(Request $request, $uuid)
    { $validate = Validator::make($request->all(),[
        'name' => 'string|min:2|max:20|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'high' => 'integer|min:175|max:190',
        'play' => 'string|in:goal_keeping,attack,defense,midline',
        'number' =>'integer|unique:players,number|min:1|max:11',
        "born"=>'date|before_or_equal:2006-1-1|after_or_equal:1995-1-1',
        'player_image' => 'file|mimes:jpg,png,jpeg,jfif',
        "from"=>'string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        "first_club"=>'string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        "career"=>'array',
        'career.*'=>'string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'sport_uuid'=>'string|exists:sports,uuid'
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        }
        try{
          
            $player=Player::where('uuid',$uuid)->first();
            $player->update($request->all());
            if($request->player_image)
            { $this->deleteFile($player->image);
            $image=$this->uploadImagePublic2($request,'players','player_image');
            if(!$image)
            {
           return  $this->apiResponse(null, false,'Failed to upload image',500);
            }
            $player->image=$image;
            $player->save();
            }
            return $this->apiResponse('uploaded successfully!');
          } catch (\Throwable $th) {
          
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
    {  try{
        $player = Player::where('uuid',$uuid)->first();

       if ($player) {
           $player->delete();
           return $this->apiResponse(["succssifull delete"],true,null,201);}
       else {
        return $this->notFoundResponse('notfound');
       
       }
    } catch (\Throwable $th) {
          
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }


    }
}
