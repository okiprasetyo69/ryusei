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
use App\Jobs\SyncSalesTurnoverMarketPlaceJob;
use App\Jobs\SyncBasketSizeJob;

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

    // Deprecated
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

    // Deprecated
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

    public function chartSalesTurnoverMarketplace(Request $request){
        try{
            $chartPerformanceSales = $this->service->chartSalesTurnoverMarketPlace($request);
            if($chartPerformanceSales != null){
                return $chartPerformanceSales;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function monitoringStock(Request $request){
        try{
            $monitoringStock = $this->service->monitoringStock($request);
            if($monitoringStock != null){
                return $monitoringStock;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportSalesTurnoverMarketPlace(Request $request){
        try{
            $reportSalesTurnoverMarketPlace = $this->service->reportSalesTurnoverMarketPlace($request);
            if($reportSalesTurnoverMarketPlace != null){
                return $reportSalesTurnoverMarketPlace;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportBestStore(Request $request){
        try{
            $reportBestStore = $this->service->reportBestStore($request);
            if($reportBestStore != null){
                return $reportBestStore;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportBasketSize(Request $request){
        try{
            $reportBasketSize = $this->service->reportBasketSize($request);
            if($reportBasketSize != null){
                return $reportBasketSize;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function syncSalesTurnoverMarketPlace(Request $request){
        try{
            SyncSalesTurnoverMarketPlaceJob::dispatch();
            return response()->json([
                'status' => 200,
                'message' => 'Sync Sales Turnover. Please wait a few minutes !',
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function syncBaksetSize(Request $request){
        try{
            SyncBasketSizeJob::dispatch();
            return response()->json([
                'status' => 200,
                'message' => 'Sync Basket Size. Please wait a few minutes !',
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
