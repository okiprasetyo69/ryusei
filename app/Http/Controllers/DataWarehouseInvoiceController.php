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

use App\Models\DataWareHouseInvoice;
use App\Models\DataWareHouseDetailInvoice;
use App\Services\Repositories\DataWarehouseInvoiceRepositoryEloquent;
use App\Jobs\SyncTransactionInvoice;

class DataWarehouseInvoiceController extends Controller
{
     /**
     * @var DataWareHouseInvoice
    */
    private DataWarehouseInvoiceRepositoryEloquent $service;

    public function __construct(DataWarehouseInvoiceRepositoryEloquent $service) 
    {
        $this->service = $service;
    }

    // WEB
    public function index(Request $request){
        return view("data_warehouse.index");
    }

    public function detail(Request $request){
        $invoice = DataWareHouseInvoice::where("id", $request->id)->first();
        $detailInvoice = DataWareHouseDetailInvoice::where("invoice_id", $request->id)->get();
        $detailInvoice = json_encode($detailInvoice);
        return view("data_warehouse.detail", compact("invoice", "detailInvoice"));
    }

    // API
    public function detailInvoice(Request $request){
        try{
            $detail = $this->service->detailInvoice($request);
            if($detail != null){
                return $detail;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getAllDataWarehouseInvoice(Request $request){
        try{
            $dataInvoice = $this->service->getDataWareHouseInvoice($request);
            if($dataInvoice != null){
                return $dataInvoice;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
    
    public function getInvoiceFromJubelio(Request $request){
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
                SyncTransactionInvoice::dispatch($userData, $startDate, $endDate);
            }
            // $result = $this->service->getDataWareHouseInvoiceFromJubelio($userData,  $startDate,   $endDate );
            // if($result){
            //     return true;
            // }
        
            return false;
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalInvoiceTransaction(Request $request){
        try{
            $totalInvoice = $this->service->getTotalInvoiceTrxDataWareHouse($request);
            if($totalInvoice != null){
                return $totalInvoice;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
