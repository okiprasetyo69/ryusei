<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Services\Repositories\DashboardProductionRepositoryEloquent;

class DashboardProductionController extends Controller
{
    private DashboardProductionRepositoryEloquent $service; 

    public function __construct(DashboardProductionRepositoryEloquent $service){
        $this->service = $service;
    }

    // WEB
    public function index(Request $request){
        return view("dashboard.production.index");
    }

    // API
    public function totalSampleDevelopment(Request $request){
        try{
            $totalSampleDevelopment = $this->service->totalSampleDevelopment($request);
            if($totalSampleDevelopment != null){
                return $totalSampleDevelopment;
            }
            return false; 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totsalDesignDevelopment(Request $request){
        try{
            $totalDesignDevelopment = $this->service->totalDesignDevelopment($request);
            if($totalDesignDevelopment != null){
                return $totalDesignDevelopment;
            }
            return false; 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
