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

use Excel;
use App\Imports\ImportTransaction;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

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

            $transaction = $this->transaction::with('channel', 'product', 'payment', 'product.category', 'product.sizes', 'postalcode');

            if( ($request->limit != null) && $request->page != null){
                $offset = ($request->page - 1) * $request->limit;

                $transaction->offset($offset)->limit($request->limit);
            }

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

                            // percetage admin charge
                            $transaction->percentage_admin_charge =  $salesChannel->admin_charge;

                            // year admin charge from sales channel
                            $transaction->year_admin_sales_channel = $salesChannel->year;
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
        try{
            $transaction = $this->transaction::where("id", $request->id)->first();
            if($transaction == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $transaction->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete transaction.',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $transaction = $this->transaction::where("id", $request->id)->first();
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

    public function update(Request $request){
        try{

            $transaction = $this->transaction;
            $transaction->fill($request->all());

            // convert to array from json params
            $transactions = json_decode($request->transactions, true);
            $adminCharge= 0;

            if($request->id != null){
                $transaction = $transaction::find($request->id);
            }

            $transaction->order_number = $transactions[0]['order_number'];
            $transaction->tracking_number = $transactions[0]['tracking_number'];
            $transaction->sku_id = $transactions[0]['sku_id'];
            $transaction->qty = $transactions[0]['qty'];
            $transaction->unit_price = $transactions[0]['unit_price'];
            $transaction->postal_code = $transactions[0]['postal_code'];
            $transaction->order_date = $request->order_date;
            $transaction->process_order_date = $request->process_order_date;
            $transaction->group_id = $request->group_id;
            $transaction->payment_method_id = $request->payment_method_id;
            $transaction->total =  $transactions[0]['qty'] *  $transactions[0]['unit_price'];

            if($request->sales_channel_id != null){
                $transaction->sales_channel_id = $request->sales_channel_id;
                $salesChannel =  SalesChannel::find($request->sales_channel_id);
                $adminCharge = $salesChannel->admin_charge;
            
                if($adminCharge!= null){
                    // admin charge
                    $transaction->admin_charge = intval(($transactions[0]['qty'] *  $transactions[0]['unit_price']) * ($adminCharge/100));
                
                    // total bersih
                    $transaction->total_net = intval($transaction->total - ($transaction->total * ($adminCharge/100)));
                }
            }
            // discount
            $unitPrice = $transactions[0]['unit_price'];
            if($transactions[0]['sku_id'] != null){
                // find barcode price
                $product = Product::find($transactions[0]['sku_id']);
                // calculate discount
                $discount =(1 -  $unitPrice / $product->price) * 100 ;
                $transaction->discount =  $discount;
            }

           
            $transaction->save();
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

    public function importTransaction(Request $request){
        try{
            
            $transaction = $this->transaction;

            if ($request->hasFile('file_import_transaction')) {
                //GET FILE
                $file = $request->file('file_import_transaction'); 
                //IMPORT FILE 
                $import = Excel::import(new ImportTransaction($request->order_date, $request->process_order_date, $request->sales_channel_id, $request->group_id, $request->payment_method_id), $file);
                if($import){
                    return response()->json([
                        'status' => 200,
                        'message' => true,
                        'data' => $transaction
                    ]); 
                }
            }  

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function upsertInvoiceTransactionSync($userData, $transactionDateFrom = null, $transactionDateTo = null){
        try{

            $transactionDateFrom = $transactionDateFrom."T17%3A00%3A00.000Z";
            $transactionDateTo = $transactionDateTo."T16%3A59%3A00.000Z&q=";
            
            $responses = $this->endPointSalesInvoiceTransaction($userData, $transactionDateFrom, $transactionDateTo);
            // dd($responses->json());
           
            return response()->json([
                'status' => 200,
                'message' => "Success sync data faktur !",
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            Log::info("Error Code : ". $ex->getCode());
            if($ex->getCode() == 0){
                $responses = $this->endPointSalesInvoiceTransaction($userData);
                Log::info("Retry on process ... ");
            }
            return false;
        }
    }

    public function endPointSalesInvoiceTransaction($userData, $transactionDateFrom, $transactionDateTo){
        
        $responses = Http::timeout(10)->retry(3, 1000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/sales/invoices/?page=1&pageSize=200&transactionDateFrom='.$transactionDateFrom.'&transactionDateTo='.$transactionDateTo);
        return $responses;

    }

 }