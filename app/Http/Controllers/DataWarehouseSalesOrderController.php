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

use App\Models\DataWareHouseOrder;
use App\Models\DataWareHouseOrderDetail;
use App\Services\Repositories\DataWarehouseSalesOrderRepositoryEloquent;
use App\Jobs\SyncSalesOrderJob;

class DataWarehouseSalesOrderController extends Controller
{
    /**
    * @var DataWareHouseOrder
    */
    private DataWarehouseSalesOrderRepositoryEloquent $service;

    public function __construct(DataWarehouseSalesOrderRepositoryEloquent $service) 
    {
        $this->service = $service;
    }

    // WEB
    public function index(Request $request){
        return view("data_warehouse.sales_order.index");
    }

    public function detail(Request $request){
        $salesOrder = DataWareHouseOrder::where("id", $request->id)->first();
        $detailSalesOrder = DataWareHouseOrderDetail::where("dwh_order_id", $request->id)->get();
        $detailSalesOrder = json_encode($detailSalesOrder);
        return view("data_warehouse.sales_order.detail", compact("salesOrder", "detailSalesOrder"));
    }

    // API
    public function getAllDataWarehouseOrder(Request $request){
        try{
            $dataOrder = $this->service->getDataWareHouseSalesOrder($request);
            if($dataOrder != null){
                return $dataOrder;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detailSalesOrderCompleted(Request $request){
        try{
            $detail = $this->service->detailSalesOrderCompleted($request);
            if($detail != null){
                return $detail;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getSalesOrderCompletedFromJubelio(Request $request){
        try{
            $validator = Validator::make(
                $request->all(), [
                    'start_date' => 'required',
                    'end_date' => 'required',
                ]
            );
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 422
                ]);
            }

            $userData = Auth::user();
            $startDate = date('Y-m-d', strtotime($request->start_date . ' -1 day'));
            $endDate =  $request->end_date;
            if($userData){
                // $dataInvoice = $this->service->getDataWareHouseOrderFromJubelio($userData, $startDate, $endDate);
                // $dataDetailInvoice = $this->service->getDataWareHouseDetailOrderTransaction($userData, $startDate, $endDate);
                // $sellPrice = $this->service->getDataWareHouseDetailOrderTransaction($userData, $startDate, $endDate);
                SyncSalesOrderJob::dispatch($userData, $startDate, $endDate);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sync product on process. Please wait a few minutes !',
                ]);
            }
        
            return false;
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalSalesOrderCompleted(Request $request){
        try{
            $totalOrder = $this->service->getTotalSalesOrderCompleted($request);
            if($totalOrder != null){
                return $totalOrder;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
