<?php

namespace App\Services\Repositories;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\SalesChannel;
use App\Services\Interfaces\TransactionService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class TransactionRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.18
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class TransactionRepositoryEloquent implements TransactionService{

    /**
     * @var Transaction
     */
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function getTransaction(Request $request){
        try{

            $transaction = $this->transaction::with('channel', 'product', 'payment', 'product.category');

            if($request->order_number != null){
                $transaction->where("order_number", "like", "%" . $request->order_number. "%");
            }

            if($request->tracking_number != null ){
                $transaction->where("tracking_number", "like", "%" . $request->tracking_number. "%");
            }

            if($request->sku != null ){
                $transaction->whereHas("product", function($q) use ($request){
                    $q->where("sku", "like", "%" . $request->sku. "%");
                });
            }

            if($request->order_date != null ){
                $transaction->where("order_date",  $request->order_date);
            }

            if($request->process_order_date != null ){
                $transaction->where("process_order_date",  $request->process_order_date);
            }

            if($request->sales_channel_id != null ){
                $transaction->where("sales_channel_id",  $request->sales_channel_id);
            }

            if($request->group_id != null ){
                $transaction->where("group_id",  $request->group_id);
            }

            if($request->group_id != null ){
                $transaction->where("group_id",  $request->group_id);
            }

            if($request->payment_method_id != null ){
                $transaction->where("payment_method_id",  $request->payment_method_id);
            }

            if($transaction != null){
                $datatables = Datatables::of( $transaction->get() );
                return $datatables->make( true );
            }

            return false;
         }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }

    public function create(Request $request){
       try{
            $transaction = $this->transaction;
            $transaction->fill($request->all());

            // convert to array from json params
            $transactions = json_decode($request->transactions, true);
            $adminCharge= 0;

            if($request->id != null){
                $transaction = $transaction::find($request->id);
            }

            foreach ($transactions as $key => $value) {
                $transaction = new Transaction();

                $transaction->sales_channel_id = $request->sales_channel_id;
                $transaction->order_number = $value['order_number'];
                $transaction->tracking_number = $value['tracking_number'];
                $transaction->sku_id = $value['sku_id'];
                $transaction->qty = $value['qty'];
                $transaction->unit_price = $value['unit_price'];
                $transaction->order_date =  $request->order_date;
                $transaction->process_order_date =  $request->process_order_date;
                $transaction->group_id =  $request->group_id;
                $transaction->payment_method_id =  $request->payment_method_id;
                $transaction->postal_code =  $value['postal_code'];
                $transaction->total =  $value['qty'] *  $value['unit_price'];

                // admin charge
                if($request->sales_channel_id != null){
                    $salesChannel =  SalesChannel::find($request->sales_channel_id);
                    $adminCharge = $salesChannel->admin_charge;
                   
                    if($adminCharge!= null){
                        // admin charge
                        $transaction->admin_charge = intval(($value['qty'] *  $value['unit_price']) * ($adminCharge/100));
                       
                        // total bersih
                        $transaction->total_net = intval($transaction->total - ($transaction->total * ($adminCharge/100)));
                    }
                }
                
                // discount
                $unitPrice = $value['unit_price'];
                if($value['sku_id'] != null){
                    // find barcode price
                    $product = Product::find($value['sku_id']);
                    // calculate discount
                    $discount =(1 -  $unitPrice / $product->price) * 100 ;
                    
                    $transaction->discount =  $discount;
                }

                $transaction->save();
            }

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $transaction
            ]); 

       }catch(Exception $ex){
        Log::error($ex->getMessage());
        return false;
    }
    }

    public function delete(Request $request){
        return true;
    }

    public function detail(Request $request){
        return true;
    }

 }