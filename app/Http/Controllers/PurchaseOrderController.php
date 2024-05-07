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
use App\Services\Interfaces\PurchaseOrderService;

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
}
