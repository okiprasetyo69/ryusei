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

use App\Models\Development;
use App\Services\Interfaces\DevelopmentService;

class ProductionController extends Controller
{
     /**
     * @var Development
    */
    
    private DevelopmentService $developmentService;

    public function __construct(DevelopmentService $developmentService) 
    {
        $this->developmentService = $developmentService;
    }

    // WEB
    public function productionView(Request $request){
        return view("production.production.index");
    }

    public function developmentView(Request $request){
        return view("production.development.index");
    }

    public function developmentAdd(Request $request){
        return view("production.development.add");
    }

    public function editDevelopment(Request $request){
        try{
            $development = Development::find($request->id);
            return view("production.development.detail", compact('development'));
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // API
    public function getAllDevelopement(Request $request){
        try{
            $development = $this->developmentService->getDevelopment($request);
            if($development != null){
                return $development;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function createDevelopment(Request $request){
        try{

            $validator = Validator::make(
                $request->all(), [
                    'article' => 'required',
                    'design_image' => 'max:2048',
                    'sample_image' => 'max:2048'
                ]
            );
    
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 422
                ]);
            }

            $development = $this->developmentService->create($request);
            if($development != null){
                return $development;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detailDevelopment(Request $request){
        try{
            $development = $this->developmentService->detail($request);
            if($development != null){
                return $development;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function updateDevelopment(Request $request){
        try{
            $development = $this->developmentService->update($request);
            if($development != null){
                return $development;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function deleteDevelopment(Request $request){
        try{
            $development = $this->developmentService->delete($request);
            if($development != null){
                return $development;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
