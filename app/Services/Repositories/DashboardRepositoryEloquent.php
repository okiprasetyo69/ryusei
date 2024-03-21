<?php

namespace App\Services\Repositories;

use App\Models\Transaction;
use App\Services\Interfaces\DashboardService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.20
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class DashboardRepositoryEloquent implements DashboardService {

    /**
    * @var Transaction
    */
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function totalQty(Request $request){
        try{
            $transaction = DB::table("transactions")
                            ->selectRaw('SUM(qty) AS qty, SUM(total) AS total_sold');

            if($request->today != null){
                $transaction =  $transaction->where("order_date", $request->today);
            }

            if($request->start_date != null){
                $transaction =  $transaction->where("order_date", ">=",$request->start_date);
            }

            if($request->end_date != null){
                $transaction =  $transaction->where("order_date", "<=",$request->end_date);
            }

            if($request->this_month != null){
                $transaction =  $transaction->whereMonth("order_date",$request->this_month);
            }

            if($request->this_year != null){
                $transaction =  $transaction->whereYear("order_date",$request->this_year);
            }

            $transaction =  $transaction->first();
          
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $transaction
            ]); 
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function bestSellingChannelStore(Request $request){
        try{
            $limit = 10;
            $transaction = DB::table("transactions")->join("sales_channels", "transactions.sales_channel_id", "=", "sales_channels.id")
                            ->select("transactions.sales_channel_id", "sales_channels.name", DB::raw("SUM(transactions.qty) as total_qty"), DB::raw("SUM(transactions.total) as total_sell") );
                            
            if($request->order_date != null){
                $transaction = $transaction->where("order_date", $request->order_date);
            }

            if($request->start_date != null){
                $transaction =  $transaction->where("order_date", ">=",$request->start_date);
            }

            if($request->end_date != null){
                $transaction =  $transaction->where("order_date", "<=",$request->end_date);
            }

            if($request->this_month != null){
                $transaction =  $transaction->whereMonth("order_date",$request->this_month);
            }

            if($request->today != null){
                $transaction =  $transaction->where("order_date", $request->today);
            }

            if($request->this_year != null){
                $transaction =  $transaction->whereYear("order_date",$request->this_year);
            }

            $transaction = $transaction->groupBy("transactions.sales_channel_id")->orderBy("total_qty", "DESC")->take($limit)->get();
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

    public function bestSellingProduct(Request $request){
        try{
            $limit = 10;
            $transaction = DB::table("transactions")->join("products", "transactions.sku_id", "=", "products.id")
                            ->select("transactions.sku_id", "products.name", "products.article" ,DB::raw("SUM(transactions.qty) as total_qty"), DB::raw("SUM(transactions.total) as total_sell") );
                            
            if($request->order_date != null){
                $transaction = $transaction->where("order_date", $request->order_date);
            }
                
            if($request->start_date != null){
                $transaction =  $transaction->where("order_date", ">=",$request->start_date);
            }
                
            if($request->end_date != null){
                $transaction =  $transaction->where("order_date", "<=",$request->end_date);
            }
            
            if($request->today != null){
                $transaction =  $transaction->where("order_date", $request->today);
            }

            if($request->this_month != null){
                $transaction =  $transaction->whereMonth("order_date",$request->this_month);
            }
                
            if($request->this_year != null){
                $transaction =  $transaction->whereYear("order_date",$request->this_year);
            }

            $transaction = $transaction->groupBy("transactions.sku_id")->orderBy("total_qty", "DESC")->take($limit)->get();
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
    
    public function getChartSelling(Request $request){
        try{
            $transaction =  DB::table("sales_channels")->join("transactions", "sales_channels.id", "=", "transactions.sales_channel_id")
                            ->select("sales_channels.name", DB::raw("SUM(transactions.total) as total") );
            
            if($request->order_date != null){
                $transaction = $transaction->where("order_date", $request->order_date);
            }
                                
            if($request->start_date != null){
                $transaction =  $transaction->where("order_date", ">=",$request->start_date);
            }
                                
            if($request->end_date != null){
                $transaction =  $transaction->where("order_date", "<=",$request->end_date);
            }
                            
            if($request->today != null){
                $transaction =  $transaction->where("order_date", $request->today);
            }
                
            if($request->this_month != null){
                $transaction =  $transaction->whereMonth("order_date",$request->this_month);
            }
                                
            if($request->this_year != null){
                $transaction =  $transaction->whereYear("order_date",$request->this_year);
            }
        
            $transaction = $transaction->groupBy("sales_channels.id")->orderBy("total", "DESC")->pluck("sales_channels.name", "total");

            $data = $transaction->keys();
            $labels = $transaction->values();

            return [
                'status' => true,
                'data'   => [
                    'labels' => $labels,
                    'data' => $data
                ]
            ];
            }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }