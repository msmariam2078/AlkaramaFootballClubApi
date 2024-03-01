<?php

namespace App\Http\Controllers;
use App\Models\Boss;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploader;
use App\Http\Resources\BossResource;
class BossController extends Controller
{
    use FileUploader,GeneralTrait;
 



    public function index()
    {
        try{
        $boss= Boss::all();
        
           
               $boss= BossResource::collection($boss);
            
            return $this->apiResponse($boss);
        }
            catch (\Throwable $th) {
   
            return $this->apiResponse(null,false,$th->getMessage(),500);
         
            }
        
        
        
        }


         public function show($uuid)
        {
            try{
        $boss= Boss::where("uuid",$uuid)->first();
        if(!$boss)
        {
            return $this->notFoundResponse(["not found this boss"]);
        }
        else
        {
            $boss= BossResource::make($boss);
        
        return $this->apiResponse($boss);} 
         }catch (\Throwable $th) {
   
            return $this->apiResponse(null,false,$th->getMessage(),500);
         
            }
        }




    public function store(Request $request)
    {
      $validate= Validator::make($request->all(),[
        "name"=>"string|required|min:3|max:20",
        "start_year"=>'required|digits:4|integer|min:1900|max:2024|unique:bosses,start_year',
        "image" =>"required|file|mimes:jpg,png,jpeg,jfif|max:2000",
        ]);
        

        if($validate->fails())
        {
            return $this->requiredField($validate->errors()->first());
        }
            try{
                
            $image= $this->uploadImagePublic2($request,'boss','image');
            
            if($image)
            {
                $uuid= str::uuid();
                $boss= Boss::firstOrCreate([
                    "uuid"=>$uuid,
                    "name"=>$request->name,
                    "start_year"=>$request->start_year,
                    "image"=>$image,
                ]);
                $boss= BossResource::make($boss);
                return $this->apiResponse($boss);
            }

            else
            {
                return $this->apiResponse(null,false,['Failed to upload image'],500);
            }
        }
        catch(\Throwable $th)
        {
            return $this->apiResponse(null , false , $th->getMessage(),500);
        }
        
        }
    



    public function update(Request $request, $uuid)
    {
        $validate= Validator::make($request->all(),[
            "name"=>"string|min:3|max:20|regex:/(^[a-zA-Z][a-zA-Z\s]{0,20}[a-zA-Z]$)/",
            "start_year"=>'digits:4|integer|min:1900|max:2024|unique:bosses,start_year',
            "image_boss" =>"file|mimes:jpg,png,jpeg,jfif",
        ]);
        
        if($validate->fails())
        {
            return $this->requiredField($validate->errors()->first());
        }
        try
        {
            $boss= Boss::where("uuid",$uuid)->first();
            $boss->update($request->all());
            if ($request->image_boss)
            {
                $this->deleteFile($boss->image);
                
            $image= $this->uploadImagePublic2($request,'boss','image_boss');
            $boss->image= $image;
            $boss->save();
            }
            return $this->apiResponse(['uploaded successfully!']);

        }
        catch(\Throwable $th)
        {
            return $this->apiResponse(null,false,$th->getMessage(),500);
        }
        
    }
    

   
    public function destroy($uuid)
    {
        $boss= Boss::where("uuid",$uuid)->first();
        if($boss)
        {
             $boss->delete();
             return $this->apiResponse(["sucessfull delete"],true,null,201);
        }
             
        else {
              return $this->notFoundResponse(['notfound']);
             
             }
    
    }
}
