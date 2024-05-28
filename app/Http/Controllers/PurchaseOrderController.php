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

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Services\Interfaces\PurchaseOrderService;
use App\Jobs\SycnPurchaseOrderJob;


class PurchaseOrderController extends Controller
{
    /**
    * @var PurchaseOrder
    */

    private PurchaseOrderService $service;

    public function __construct(PurchaseOrderService $service) 
    {
        $this->service = $service;
    }

    // WEB
    public function index(Request $request){
        try{
            
           return view("purchase_order.index");
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function add(Request $request){
        try{
            
            return view("purchase_order.add");
         }catch(Exception $ex){
             Log::error($ex->getMessage());
             return false;
         }
    }

    public function edit(Request $request){
        try{
            $purchaseOrder = PurchaseOrder::find($request->id);
            $purchaseOrderDetail = PurchaseOrderDetail::where("purchase_id", $request->id)->get();
            $purchaseOrderDetail = json_encode($purchaseOrder);
            return view("purchase_order.detail", compact("purchaseOrder", "purchaseOrderDetail"));
         }catch(Exception $ex){
             Log::error($ex->getMessage());
             return false;
         }
    }

    public function detailPurchaseOrder(Request $request){
        try{

            $validator = Validator::make($request->all(), [
                'purchase_id' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }
    
            $purchasingOrderDetail = $this->service->purchaseOrderDetail($request);
            if($purchasingOrderDetail) {
                return $purchasingOrderDetail;
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // API
    public function getPurchaseOrder(Request $request){
        try{
            $purchaseOrder = $this->service->getPurchaseOrder($request);
            if($purchaseOrder != null){
                return $purchaseOrder;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getPurchaseOrderFromJubelio(Request $request){
        try{
            $userData = Auth::user();
            if($userData){
                SycnPurchaseOrderJob::dispatch($userData);
                return response()->json([
                    'status' => 200,
                    'message' => 'Sync purchase order on process. Please wait a few minutes !',
                ]);
            }
        
            return false;

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalPurchaseOrder(Request $request){
        try{
            $totalPurchaseOrder = $this->service->getTotalPurchaseOrder($request);
            if($totalPurchaseOrder != null){
                return $totalPurchaseOrder;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
   
}
