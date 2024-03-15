<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Closure;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Models\Size;
use App\Services\Interfaces\SizeService;

class SizeController extends Controller
{

    /**
     * @var Size
    */
    
    private SizeService $service;

    public function __construct(SizeService $service) 
    {
        $this->service = $service;
    }

    public function getAllSize(Request $request){
        try{
            $size = $this->service->getAllSize($request);
            if($size != null){
                return $size;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
