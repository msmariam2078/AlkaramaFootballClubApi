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
      if($players->isEmpty())
      {return $this->notFoundResponse('not found players');}
      else{
      $players= PlayerResource::collection($players);} 
      return
       $this->apiResponse($players);
    }

    public function show ($uuid)
    {

      $player=Player::where('uuid',$uuid)->first(); 
      if(!$player)
      {return $this->notFoundResponse('not found player ');}
      else{
      $player= PlayerDetailsResource::make($player);} 
      return
       $this->apiResponse($player);
    }




    public function showByplay(Request $request)
    {

    $players=Player::where('play',$request->play)->where('sport_id',$request->sport_id)->get();
  
    if( $players->isEmpty()){
    return $this->notFoundResponse('notfound players');
    }

     else{
    $players=PlayerResource::collection($players); 
    return $this->apiResponse($players);
   

     }}
   


     public function store(Request $request)
    {   
        try {
        $validate = Validator::make($request->all(),[
        'name' => 'string|min:2|max:20|required|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'high' => 'required|integer|min:175|max:190',
        'play' => 'required|string|in:goal_keeping,attack,defense,midline',
        'number' =>'required|integer|unique:players,number|min:1|max:11',
        "born"=>'required|date|before_or_equal:2006-1-1|after_or_equal:1995-1-1',
        'image' => 'required|file|mimes:jpg,png,jpeg,jfif',
        "from"=>'required|string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        "first_club"=>'required|string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        "career"=>'required|array',
        'career.*'=>'required|string|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/',
        'sport_uuid'=>'required|string|exists:sports,uuid'
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        }
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
        return $this->apiResponse($player);
    } else{
        return  $this->apiResponse(null, false,'Failed to upload image',500);
       


    }  } catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }

 
   

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $player = Player::find($id);
            if($player){
            $play=$player->update($request->all());
            return $this->apiResponse($play,true,null,201);}
        else{
            return $this->notFoundResponse('notfound');

        }




    }}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Player  $player
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player = Player::find($id);

       if ($player) {
           $player->delete();
           return $this->apiResponse(["succssifull delete"],true,null,201);}
       else {
        return $this->notFoundResponse('notfound');
       
       }


    }
}
