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

use App\Models\SalesReturn;
use App\Models\SalesReturnDetail;
use App\Services\Repositories\SalesReturnRepositoryEloquent;
use App\Jobs\SyncSalesReturnJob;


class SalesReturnController extends Controller
{
     /**
     * @var SalesReturn
    */
    private SalesReturnRepositoryEloquent $service;

    public function __construct(SalesReturnRepositoryEloquent $service) 
    {
        $this->service = $service;
    }

    // WEB
    public function index(Request $request){
        return view("data_warehouse.sales_return.index");
    }

    public function detail(Request $request){
        $salesReturn = SalesReturn::where("id", $request->id)->first();
        $detailSalesReturn = SalesReturnDetail::where("sales_return_id", $request->id)->get();
        $detailSalesReturn = json_encode($detailSalesReturn);
        return view("data_warehouse.sales_return.detail", compact("salesReturn", "detailSalesReturn"));
    }

    // API
    public function getAllSalesReturn(Request $request){
        try{
            $salesReturn = $this->service->getAllSalesReturn($request);
            if($salesReturn != null){
                return $salesReturn;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detailSalesReturn(Request $request){
        try{
            $detail = $this->service->detailSalesReturn($request);
            if($detail != null){
                return $detail;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getSalesReturnFromJubelio(Request $request){
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
                SyncSalesReturnJob::dispatch($userData, $startDate, $endDate);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sync return on process. Please wait a few minutes !',
                ]);
            }
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalSalesReturn(Request $request){
        try{
            $totalReturn = $this->service->getTotalSalesReturn($request);
            if($totalReturn != null){
                return $totalReturn;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
