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

    public function totalFilmDevelopment(Request $request){
        try{
            $totalFilmDevelopment = $this->service->totalFilmDevelopment($request);
            if($totalFilmDevelopment != null){
                return $totalFilmDevelopment;
            }
            return false; 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalQtyPerCategory(Request $request){
        try{
            $totalQtyPerCategory = $this->service->totalQtyPerCategory($request);
            if($totalQtyPerCategory != null){
                return $totalQtyPerCategory;
            }
            return false; 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalPoDevelopment(Request $request){
        try{
            $totalPoDevelopment = $this->service->totalPoStatus($request);
            if($totalPoDevelopment != null){
                return $totalPoDevelopment;
            }
            return false; 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalProductionDevelopment(Request $request){
        try{
            $totalProductionDevelopment = $this->service->totalProductionStatus($request);
            if($totalProductionDevelopment != null){
                return $totalProductionDevelopment;
            }
            return false; 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalStatusSampleDevelopment(Request $request){
        try{
            $totalStatusSampleDevelopment = $this->service->totalSamplingStatus($request);
            if($totalStatusSampleDevelopment != null){
                return $totalStatusSampleDevelopment;
            }
            return false; 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalStatusFilmDevelopment(Request $request){
        try{
            $totalStatusFilmDevelopment = $this->service->totalFilmStatus($request);
            if($totalStatusFilmDevelopment != null){
                return $totalStatusFilmDevelopment;
            }
            return false; 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

}
