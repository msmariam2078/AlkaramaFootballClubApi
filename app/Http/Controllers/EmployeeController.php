<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Sport;
use App\Http\Traits\FileUploader;
use Illuminate\Support\Facades\Validator;
use  App\Http\Resources\EmployeeResource;
class EmployeeController extends Controller
{
    use GeneralTrait,FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    try{
    $employee=Employee::all();
    $employee=EmployeeResource::collection($employee);
    return $this->apiResponse($employee); 

     } catch (\Throwable $th) {
          
    return $this->apiResponse(null,false,$th->getMessage(),500);
    }


    }

    public function showByType(Request $request)
    {    
        if($request->jobtype=='manager')
        {
        $manager=Employee::where('job_type','manager')->get();
        $manager=EmployeeResource::collection($manager);
        return $this->apiResponse($manager);    }
       else{
        $coach=Employee::where('job_type','coach')->get();
        $coach=EmployeeResource::collection($coach);
        return $this->apiResponse($coach);    

           }



    }

    public function show($uuid){
 
        $employee=Employee::where('uuid',$uuid)->first();
        if(!$employee)
        {
            return $this->apiResponse(null,false,'not found',404);  
        }
        $employee=EmployeeResource::make($employee);
        return $this->apiResponse($employee);

    }
    
    public function store(Request $request)
    {
       
            $validate = Validator::make($request->all(),[
            'name' => 'string|min:2|max:20|required',
            'job_type' => 'required|string|in:manager,coach',
            'work' => 'required|string',
            'image' => 'required|file|mimes:jpg,png,jpeg,jfif|max:2000',
            "sport_uuid"=>'required|string|exists:sports,uuid'
            ]);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try { 
           
            $image=$this->uploadImagePublic2($request,'employee','image');
            if(!$image){
            return  $this->apiResponse(null, false,'Failed to upload image',500);}
            $uuid=Str::uuid();
            $sport_id=Sport::where('uuid',$request->input('sport_uuid'))->value('id');
            $employee=Employee::firstOrCreate(['uuid'=>$uuid,
            'name'=>$request->input('name'),
            'job_type'=>$request->input('job_type'),
            'image'=>$image,
            'work'=>$request->input('work'),
            'sport_id'=>$sport_id,
    
        ]);
        $employee=EmployeeResource::make($employee);
        return $this->apiResponse($employee);
         }  catch (\Throwable $th) {
      
        return $this->apiResponse(null,false,$th->getMessage(),500);
        }
    }

   
    public function update(Request $request, $uuid)
    {
            $validate = Validator::make($request->all(),[
                'name' => 'string|min:2|max:20',
                'job_type' => 'string|in:manager,coach',
                'work' => 'string',
                'img' => 'file|mimes:jpg,png,jpeg,jfif',
                "sport_uuid"=>'string|exists:sports,uuid']);
            if($validate->fails()){
            return $this->requiredField($validate->errors()->first());    
            }
            try{
            
            $employee=Employee::where('uuid',$uuid)->first();
            $employee->update($request->all());
            if($request->img)
            { $this->deleteFile($employee->image);
            $image=$this->uploadImagePublic2($request,'employee','img');
            if(!$image)
            {
            return  $this->apiResponse(null, false,['Failed to upload image'],500);
            }
            $employee->image=$image;
            $employee->save();
            }
         
            return $this->apiResponse(['uploaded successfully!']);
        
        } catch (\Throwable $th) {
          
            return $this->apiResponse(null,false,$th->getMessage(),500);
            }
        }
        




    
    public function destroy($uuid)
    {


        $employee= Employee::where('uuid',$uuid)->first();

        if ($employee) {
            $employee->delete();
            return $this->apiResponse(["succssifull delete"],true,null,201);}
        else {
         return $this->notFoundResponse(['not found']);
        
        }
 
        
    }
}
