<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Sport;
use App\Models\Prime;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\FileUploader;
use App\Http\Resources\PrimeResource;
use Illuminate\Support\Str;


class PrimeController extends Controller
{
    use GeneralTrait, FileUploader;
    public function index(){

        $primes=Prime::all();
      
         $clubs=PrimeResource::collection($primes);
         return $this->apiResponse($primes);
         

    }
}
