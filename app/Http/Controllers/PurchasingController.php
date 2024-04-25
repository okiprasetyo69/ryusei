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

use App\Models\PurchaseInvoice;
use App\Models\PurchasingInvoiceDetail;
use App\Services\Interfaces\PurchasingInvoiceService;

class PurchasingController extends Controller
{
     /**
    * @var PurchaseInvoice
    */

    private PurchasingInvoiceService $service;

    public function __construct(PurchasingInvoiceService $service) 
    {
        $this->service = $service;
    }

    // WEB
    public function index(Request $request){
        return view("purchasing.index");
    }
    
    public function add(Request $request){
        return view("purchasing.add");
    }

    public function edit(Request $request){
        $purchaseInvoice = PurchaseInvoice::find($request->id);
        $purchaseInvoiceDetail = PurchasingInvoiceDetail::where("invoice_id", $request->id)->get();
        $purchaseInvoiceDetail = json_encode($purchaseInvoice);
        return view("purchasing.detail", compact("purchaseInvoice","purchaseInvoiceDetail"));
    }

    // API
    public function getPurchasingInvoice(Request $request){
        try{
            $purchasingInvoice = $this->service->getPurchasingInvoice($request);
            if($purchasingInvoice != null){
                return $purchasingInvoice;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            
            $validator = Validator::make(
                $request->all(), [
                    'vendor_id' => 'required',
                    'date' => 'required',
                    'due_date' => 'required',
                    'invoices' => 'required',
                ]
            );

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 422
                ]);
            }

            $purchaseInvoice = $this->service->create($request);

            if($purchaseInvoice) {
                return $purchaseInvoice;
            }

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function update(Request $request){
        try{
            $validator = Validator::make(
                $request->all(), [
                    'id' => 'required',
                    'vendor_id' => 'required',
                    'date' => 'required',
                    'due_date' => 'required',
                    'invoices' => 'required',
                ]
            );
    
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 422
                ]);
            }

            $purchasingInvoice = $this->service->update($request);

            if($purchasingInvoice) {
                return $purchasingInvoice;
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }
    
            $purchasingInvoice = $this->service->delete($request);
            if($purchasingInvoice) {
                return $purchasingInvoice;
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detailInvoice(Request $request){

        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors(),
                'status' => 422
            ]);
        }

        $purchasingInvoice = $this->service->detailInvoiceItem($request);
        if($purchasingInvoice) {
            return $purchasingInvoice;
        }
    }
}   
