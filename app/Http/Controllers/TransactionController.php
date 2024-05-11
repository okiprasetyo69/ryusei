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

use App\Models\Transaction;
use App\Models\SalesChannel;
use App\Models\PaymentMethod;
use App\Services\Interfaces\TransactionService;
use App\Jobs\SyncTransactionInvoice;

class TransactionController extends Controller
{
    /**
    * @var Transaction
    */
    
    private TransactionService $service;

    public function __construct(TransactionService $service) 
    {
        $this->service = $service;
    }

    // WEB
    public function index(Request $request){
        return view("transaction.index");
    }

    public function add(Request $request){
        return view("transaction.add");
    }

    public function edit(Request $request){
        $transaction = Transaction::with('product')->find($request->id);
        $saleschannel = SalesChannel::all();
        $paymentmethod = PaymentMethod::all();
        $admincharge = SalesChannel::where("id", $transaction->sales_channel_id)->first();

        return view("transaction.edit",  compact('transaction', 'saleschannel', 'paymentmethod', 'admincharge'));
    }

    public function downloadFormatImportTransaksi(){
        $path = public_path('/import/Format_Import_Transaksi.xlsx');
        return response()->download($path);
    }

    // API
    public function getTransaction(Request $request){
        try{
            $transaction = $this->service->getTransaction($request);
            if($transaction != null){
                return $transaction;
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
                'sales_channel_id' => 'required',
                'order_date' => 'required',
                'process_order_date' => 'required',
                'group_id' => 'required',
                'payment_method_id' => 'required',
                'transactions' => 'required',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $transaction = $this->service->create($request);

        if($transaction) {
            return $transaction;
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

        $transaction = $this->service->delete($request);
        if($transaction) {
            return $transaction;
        }
    }

    public function detail(Request $request){
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

        $transaction = $this->service->detail($request);
        return $transaction;
    }   

    public function update(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'sales_channel_id' => 'required',
                'order_date' => 'required',
                'process_order_date' => 'required',
                'group_id' => 'required',
                'payment_method_id' => 'required',
                'transactions' => 'required',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $transaction = $this->service->update($request);

        if($transaction) {
            return $transaction;
        }
    }

    public function importTransaction(Request $request){
        try{
            $validator = Validator::make(
                $request->all(), [
                    'file_import_transaction' => 'required|mimes:xls,xlsx'
                ]
            );

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 422
                ]);
            }

            $importTransaction = $this->service->importTransaction($request);

            if($importTransaction) {
                return $importTransaction;
            }
           
       }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
       }
    }

    public function getInvoiceTransactionFromJubelio(Request $request){
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
                return response()->json([
                    'status' => 200,
                    'message' => 'Sync transaction invoice on process. Please wait a few minutes !',
                ]);
            }
        
            return false;
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
