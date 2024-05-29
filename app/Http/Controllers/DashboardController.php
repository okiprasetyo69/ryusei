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
use App\Services\Repositories\DashboardRepositoryEloquent;
use App\Jobs\SyncSalesTurnoverMarketPlaceJob;
use App\Jobs\SyncBasketSizeJob;
use App\Jobs\SyncBestProductJob;
use App\Jobs\SyncSaleThroughJob;
use App\Jobs\SyncSaleStockRatioJob;

class DashboardController extends Controller
{

    private DashboardService $service;
    private DashboardRepositoryEloquent $dashboardEloquent;

    public function __construct(DashboardService $service, DashboardRepositoryEloquent $dashboardEloquent) 
    {
        $this->service = $service;
        $this->dashboardEloquent = $dashboardEloquent;
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

    public function reportBestProduct(Request $request){
        try{
            $reportBestProduct = $this->service->reportBestProduct($request);
            if($reportBestProduct != null){
                return $reportBestProduct;
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

    public function reportAov(Request $request){
        try{
            $reportAov = $this->service->reportAov($request);
            if($reportAov != null){
                return $reportAov;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportSellStockRatioDaily(Request $request){
        try{
            $reportSellStockRatioDaily = $this->service->reportSellStockRatioDaily($request);
            if($reportSellStockRatioDaily != null){
                return $reportSellStockRatioDaily;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportSellStockRatioMontly(Request $request){
        try{
            $reportSSRMonthly = $this->service->reportSSRMonthly($request);
            if($reportSSRMonthly != null){
                return $reportSSRMonthly;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportSellThrough(Request $request){
        try{
            $reportSellThrough = $this->dashboardEloquent->reportSellThrough($request);
            if($reportSellThrough != null){
                return $reportSellThrough;
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

    public function syncBestProduct(Request $request){
        try{
            //$sync = $this->dashboardEloquent->syncBestProduct();
            SyncBestProductJob::dispatch();
            return response()->json([
                'status' => 200,
                'message' => 'Sync Top 10 Best Product Sell. Please wait a few minutes !',
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function syncSellThrough(Request $request){
        try{
            //$sync = $this->dashboardEloquent->syncSellThrough();
            SyncSaleThroughJob::dispatch();
            return response()->json([
                'status' => 200,
                'message' => 'Sync Sell Through. Please wait a few minutes !',
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function syncSaleStockRatio(Request $request){
        try{
            // $sync = $this->dashboardEloquent->syncSaleStockRatio();
            SyncSaleStockRatioJob::dispatch();
            return response()->json([
                'status' => 200,
                'message' => 'Sync Sell Stock Ratio. Please wait a few minutes !',
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
