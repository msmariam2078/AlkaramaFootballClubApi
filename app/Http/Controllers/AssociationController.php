<?php

namespace App\Http\Controllers;

use App\Models\Association;
use Illuminate\Http\Request;
use App\Http\Resources\AssociationResource;
use Illuminate\Support\str;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\GeneralTrait;
use App\Http\Traits\FileUploader;
use App\Models\Sport;

class AssociationController extends Controller
{    use GeneralTrait,FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
             $association=Association::all();
       
            $association=AssociationResource::collection($association);
            return $this->apiResponse($association);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
        
            $validate = Validator::make($request->all(),[
                'boss' =>'string|min:2|max:50|required',
                'descreption'=>'string|min:10|max:255',
                'country' =>'required|string',
                'image'=>'required|file|mimes:jpg,png,jpeg,jfif',
                "sport_uuid"=>'required|string|exists:sports,uuid'
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
             
            $image=$this->uploadImagePublic2($request,'Association','image'); 
           // dd($request->image,$image);
            if(!$image)
            {
            return  $this->apiResponse(null, false,['Failed to upload image'],500); 
             }
    
            else{
             $uuid=Str::uuid();
            $sport_id=Sport::where('uuid',$request->input('sport_uuid'))->value('id');
            $association=Association::firstOrCreate(['uuid'=>$uuid,
            'boss'=>$request->input('boss'),
            'descreption'=>$request->input('descreption'),
            'country'=>$request->input('country'),
            'image'=>$image,
            'sport_id'=>$sport_id,
    
        ]);
            $association= AssociationResource::make($association); 
            return $this->apiResponse( $association) ;  
            
           
    
    
        }  } catch (\Throwable $th) {
          
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function show( $uuid)
    {
       
        try{
            $association= Association::where('uuid',$uuid)->first();
           
            if(!$association)
            {
                return $this->apiResponse(null,false,['not found'],404); 
            }
      
            $association=AssociationResource::make($association);
            return $this->apiResponse($association); 

           } catch (\Throwable $th) {
                  
           return $this->apiResponse(null,false,$th->getMessage(),500);
                    }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function edit(Association $association)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$uuid)
    { 
        $association=Association::find($uuid);
        $validate = Validator::make($request->all(),[
        'boss' => 'string|min:2|max:20',
        'descreption' => 'string|min:10|max:255',
        'country' => 'string',
        'logo' => 'file|mimes:jpg,png,jpeg,jfif',
        "sport_uuid"=>'string|exists:sports,uuid'
    
        ]);
        if($validate->fails()){
        return $this->requiredField($validate->errors()->first());    
        }
        try{
            $association=Association::where('uuid',$uuid)->first();
        if(!$association)
        {
         return $this->notFoundResponse(['not found']);

        }
        else{
            $association->update($request->all());
        if($request->logo) {
        $this->deleteFile($association->image);
        $image=$this->uploadImagePublic2($request,'Association','logo');
        if(!$image){
        return  $this->apiResponse(null, false,['Failed to upload image'],500);
        }
       
            $association->image=$image;
            $association->save();}
        
        
   
    return  $this->apiResponse( ['updated successfuly']);
    
    }}
    catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Association  $association
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $association=Association::where('uuid',$uuid)->first(); 
       if(!$association)
       {
       return $this->notFoundResponse(["cannot deleted this association"]);
       }
       else{
        $association->delete();
       return $this->apiResponse(["deleted successfully!"]);
    }
    }
}
