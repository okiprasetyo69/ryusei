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

use App\Models\SalesInvoice;
use App\Models\SalesInvoiceDetail;
use App\Services\Interfaces\SalesInvoiceService;

class SalesInvoiceController extends Controller
{
    /**
    * @var SalesInvoice
    */
    
    private SalesInvoiceService $service;

    public function __construct(SalesInvoiceService $service) 
    {
        $this->service = $service;
    }

    // WEB
    public function index(Request $request){
        return view("sales_invoice.index");
    }

    public function add(Request $request){
        return view("sales_invoice.add");
    }

    public function edit(Request $request){
        $invoice = SalesInvoice::find($request->id);
        $invoiceDetail = SalesInvoiceDetail::where("invoice_id", $request->id)->get();
        $invoiceDetail = json_encode($invoiceDetail);
        return view("sales_invoice.detail", compact("invoice","invoiceDetail"));
    }

    // API Response
    public function getAllSalesInvoice(Request $request){
        try{
            $salesInvoice = $this->service->getSalesInvoice($request);
            if($salesInvoice != null){
                return $salesInvoice;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){

        $validator = Validator::make(
            $request->all(), [
                'customer_id' => 'required',
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

        $salesInvoice = $this->service->create($request);

        if($salesInvoice) {
            return $salesInvoice;
        }
    }

    public function update(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'id' => 'required',
                'customer_id' => 'required',
                'date' => 'required',
                'due_date' => 'required',
                // 'warehouse_id' => 'required',
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

        $salesInvoice = $this->service->update($request);

        if($salesInvoice) {
            return $salesInvoice;
        }
    }

    public function delete(Request $request){
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

        $salesInvoice = $this->service->delete($request);
        if($salesInvoice) {
            return $salesInvoice;
        }
    }

    public function detail(Request $request){
        return true;
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

        $salesInvoice = $this->service->detailInvoiceItem($request);
        if($salesInvoice) {
            return $salesInvoice;
        }
    }

    public function deleteDetailInvoice(Request $request){
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

        $salesInvoice = $this->service->deleteDetailInvoice($request);
        if($salesInvoice) {
            return $salesInvoice;
        }
    }
}
