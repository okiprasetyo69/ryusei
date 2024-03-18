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
use App\Services\Interfaces\TransactionService;

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
        return view("transaction.edit");
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
}
