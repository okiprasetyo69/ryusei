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

use App\Services\Interfaces\DashboardService;


class DashboardController extends Controller
{

    private DashboardService $service;

    public function __construct(DashboardService $service) 
    {
        $this->service = $service;
    }


    public function totalQty(Request $request){
        try{
            $totalQty = $this->service->totalQty($request);
            if($totalQty != null){
                return $totalQty;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function bestSellingChannelStore(Request $request){
        try{
            $bestStore = $this->service->bestSellingChannelStore($request);
            if($bestStore != null){
                return $bestStore;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function bestSellingProduct(Request $request){
        try{
            $bestProductSold = $this->service->bestSellingProduct($request);
            if($bestProductSold != null){
                return $bestProductSold;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getChartSelling(Request $request){
        try{
            $chartPerformance = $this->service->getChartSelling($request);
            if($chartPerformance != null){
                return $chartPerformance;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
