<?php

namespace App\Services\Repositories;

use App\Models\Transaction;
use App\Models\ItemStock;
use App\Models\DataWareHouseOrder;
use App\Models\DataMartMarketPlace;
use App\Models\DataMartProductDetail;
use App\Models\BasketSizeReport;
use App\Models\Product;
use App\Models\DataMartSellThrough;
use App\Models\DataMartSaleStockRatio;
use App\Models\SellStockRatioReport;
use App\Services\Interfaces\ItemStockService;
use App\Services\Interfaces\DashboardService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
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
     * @var ItemStock
     */
    private ItemStock $itemStock;

    /**
    * @var Transaction
    */
    private Transaction $transaction;

     /**
     * @var DataWareHouseOrder
     */
    private DataWareHouseOrder $salesOrder;

    public function __construct(Transaction $transaction, ItemStock $itemStock,  DataWareHouseOrder $salesOrder)
    {
        $this->transaction = $transaction;
        $this->itemStock = $itemStock;
        $this->salesOrder = $salesOrder;
    }

    public function totalQty(Request $request){
        try{
            // $transaction = DB::table("transactions")->selectRaw('SUM(qty) AS qty, SUM(total) AS total_sold');

            $transaction = DB::table("data_ware_house_order_Details")
                            ->select(DB::raw('COUNT(sku_code) as total_item'), DB::raw('SUM(amount) as total_sold'));

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

    // Deprecated
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

    // Deprecated
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
    
    // Deprecated
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

    // Report Best 10 Store From Market Place
    public function reportBestStore(Request $request){
        try{
            $limit = 10;
            $bestStore =  DB::table("data_mart_market_places")
                            ->select("channel_name", "store_name", DB::raw("SUM(grand_total) as total"));

            if($request->start_date != null){
                $bestStore =  $bestStore->where("transaction_date", ">=",$request->start_date);
            }
                
            if($request->end_date != null){
                $bestStore =  $bestStore->where("transaction_date", "<=",$request->end_date);
            }
                
            if($request->this_month != null){
                $bestStore =  $bestStore->whereMonth("transaction_date",$request->this_month);
            }
                
            if($request->today != null){
                $bestStore =  $bestStore->where("transaction_date", $request->today);
            }
                
            if($request->this_year != null){
                $bestStore =  $bestStore->whereYear("transaction_date",$request->this_year);
            }

            $bestStore = $bestStore->groupBy("channel_name", "store_name")->orderBy("total", "DESC")->take($limit)->get();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $bestStore
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // Report Top 10 Product Market Place
    public function reportBestProduct(Request $request){
        try{
            $limit = 10;

            $bestProduct = DB::table("data_mart_product_details")->select("name", DB::raw("SUM(qty_sold) as qty_sold"));

            if($request->start_date != null){
                $bestProduct =  $bestProduct->where("transaction_date", ">=",$request->start_date);
            }
                
            if($request->end_date != null){
                $bestProduct =  $bestProduct->where("transaction_date", "<=",$request->end_date);
            }
            
            if($request->today != null){
                $bestProduct =  $bestProduct->where("transaction_date", $request->today);
            }

            if($request->this_month != null){
                $bestProduct =  $bestProduct->whereMonth("transaction_date",$request->this_month);
            }
                
            if($request->this_year != null){
                $bestProduct =  $bestProduct->whereYear("transaction_date",$request->this_year);
            }

            $bestProduct = $bestProduct->groupBy("name")->orderBy("qty_sold", "DESC")->take($limit)->get(); 
          
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $bestProduct
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // Report Chart based on omset from each Martketplace
    public function chartSalesTurnoverMarketPlace(Request $request){
        try{
            $salesTurnOverMarketPlace = DB::table("data_mart_market_places")
                                        ->select("channel_name", DB::raw("SUM(grand_total) as total"));
        
            if($request->start_date != null){
                $salesTurnOverMarketPlace =  $salesTurnOverMarketPlace->where("transaction_date", ">=", $request->start_date);
            }
                                
            if($request->end_date != null){
                $salesTurnOverMarketPlace =  $salesTurnOverMarketPlace->where("transaction_date", "<=",$request->end_date);
            }

            if($request->today != null){
                $salesTurnOverMarketPlace =  $salesTurnOverMarketPlace->where("transaction_date", $request->today);
            }
                
            if($request->this_month != null){
                $salesTurnOverMarketPlace =  $salesTurnOverMarketPlace->whereMonth("transaction_date", $request->this_month);
            }
                                
            if($request->this_year != null){
                $salesTurnOverMarketPlace =  $salesTurnOverMarketPlace->whereYear("transaction_date", $request->this_year);
            }

            $salesTurnOverMarketPlace = $salesTurnOverMarketPlace->groupBy("channel_name")->orderBy("total", "DESC")->pluck("channel_name", "total");
            $data = $salesTurnOverMarketPlace->keys();
            $labels = $salesTurnOverMarketPlace->values();

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

    // Report Monitoring stock
    public function monitoringStock(Request $request){
        try{
            $itemStock = ItemStock::with('product', 'product.category', 'product.unit', 'item')->orderBy('qty', 'DESC');

            if($request->category_name != null ){
                $itemStock = $itemStock->whereHas("product", function($q) use ($request){
                    $q->where("article", "like", "%" . $request->category_name. "%");
                });
            }
            $itemStock = $itemStock->get();

            $datatables = Datatables::of($itemStock);
            return $datatables->make( true );
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // Report Omset Marketplace per daily
    public function reportSalesTurnoverMarketPlace(Request $request){
        try{
            $reportSalesTurnoverMarketPlace = DataMartMarketPlace::orderBy("transaction_date", "DESC");

            if($request->start_date != null){
                $reportSalesTurnoverMarketPlace =  $reportSalesTurnoverMarketPlace->where("transaction_date", ">=",$request->start_date);
            }

            if($request->end_date != null){
                $reportSalesTurnoverMarketPlace =  $reportSalesTurnoverMarketPlace->where("transaction_date", "<=",$request->end_date);
            }

            if($request->today != null){
                $reportSalesTurnoverMarketPlace =  $reportSalesTurnoverMarketPlace->where("transaction_date", $request->today);
            }

            if($request->this_month != null){
                $reportSalesTurnoverMarketPlace =  $reportSalesTurnoverMarketPlace->whereMonth("transaction_date", $request->this_month);
            }
                
            if($request->this_year != null){
                $reportSalesTurnoverMarketPlace =  $reportSalesTurnoverMarketPlace->whereYear("transaction_date",$request->this_year);
            }

            $reportSalesTurnoverMarketPlace = $reportSalesTurnoverMarketPlace->get();
            $datatables = Datatables::of($reportSalesTurnoverMarketPlace);
            return $datatables->make(true);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportBasketSize(Request $request){
        try{
            $reportBasketSize = BasketSizeReport::orderBy("transaction_date", "DESC");

            if($request->start_date != null){
                $reportBasketSize =  $reportBasketSize->where("transaction_date", ">=",$request->start_date);
            }

            if($request->end_date != null){
                $reportBasketSize =  $reportBasketSize->where("transaction_date", "<=",$request->end_date);
            }

            if($request->today != null){
                $reportBasketSize =  $reportBasketSize->where("transaction_date", $request->today);
            }

            if($request->this_month != null){
                $reportBasketSize =  $reportBasketSize->whereMonth("transaction_date", $request->this_month);
            }
                
            if($request->this_year != null){
                $reportBasketSize =  $reportBasketSize->whereYear("transaction_date",$request->this_year);
            }

            $reportBasketSize = $reportBasketSize->get();
            $datatables = Datatables::of($reportBasketSize);
            return $datatables->make(true);
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportAov(Request $request){
        try{
            return true;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportSellStockRatioDaily(Request $request){
        try{
            $reportSSR = SellStockRatioReport::orderBy("transaction_date", "DESC");

            if($request->start_date != null){
                $reportSSR =  $reportSSR->where("transaction_date", ">=",$request->start_date);
            }

            if($request->end_date != null){
                $reportSSR =  $reportSSR->where("transaction_date", "<=",$request->end_date);
            }

            if($request->today != null){
                $reportSSR =  $reportSSR->where("transaction_date", $request->today);
            }

            if($request->this_month != null){
                $reportSSR =  $reportSSR->whereMonth("transaction_date", $request->this_month);
            }
                
            if($request->this_year != null){
                $reportSSR =  $reportSSR->whereYear("transaction_date",$request->this_year);
            }

            $reportSSR =  $reportSSR->get();
            $datatables = Datatables::of($reportSSR);
            return $datatables->make(true);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportSSRMonthly(Request $request){
        try{
            $reportSSRMonthly = DB::table("sell_stock_ratio_reports")
                        ->select(DB::raw("DATE_FORMAT(transaction_date, '%M') as by_month"), DB::raw("DATE_FORMAT(transaction_date, '%Y') as by_year"), DB::raw("SUM(total_sales_turn_over) as omset"), DB::raw("SUM(total_inventory_value) as inv_value"),  DB::raw("(SUM(total_sales_turn_over) / SUM(total_inventory_value)) * 100  as ssr_month"));
            $reportSSRMonthly = $reportSSRMonthly->groupBy("by_month", "by_year")->get();
            $datatables = Datatables::of($reportSSRMonthly);
            return $datatables->make(true);
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportSellThrough(Request $request){
        try{
            // $reportSellThrough = DataMartSellThrough::orderBy("sync_date", "DESC");
            $reportSellThrough = DB::table("data_mart_sell_throughs")
                                ->select("name", "sync_date", DB::raw("SUM(total_unit_received) as total_unit_received"), DB::raw("SUM(total_unit_sold) as total_unit_sold"), DB::raw("SUM(total_unit_sold) / SUM(total_unit_received) * 100 as sell_throughs"));

            if($request->start_date != null){
                $reportSellThrough =  $reportSellThrough->where("sync_date", ">=",$request->start_date);
            }

            if($request->end_date != null){
                $reportSellThrough =  $reportSellThrough->where("sync_date", "<=",$request->end_date);
            }

            if($request->today != null){
                $reportSellThrough =  $reportSellThrough->where("sync_date", $request->today);
            }

            if($request->this_month != null){
                $reportSellThrough =  $reportSellThrough->whereMonth("sync_date", $request->this_month);
            }
                
            if($request->this_year != null){
                $reportSellThrough =  $reportSellThrough->whereYear("sync_date",$request->this_year);
            }
            //$reportSellThrough = $reportSellThrough->get();
            $reportSellThrough = $reportSellThrough->groupBy("name", "sync_date")->orderBy("sell_throughs", "DESC")->get(); 

            $datatables = Datatables::of($reportSellThrough);
            return $datatables->make(true);
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // Best Store From Marketplace
    public function syncSalesTurnOver(){
        try{
            $limit = 100;
            $dataWareHouseSalesOrder =  DB::table("data_ware_house_orders")
                                        ->select("channel_id", "channel_name","transaction_date" ,"store_name", DB::raw("SUM(grand_total) as total"));
                                       
            $dataWareHouseSalesOrder = $dataWareHouseSalesOrder->groupBy("channel_id", "channel_name", "transaction_date", "store_name")
                                        ->orderBy("transaction_date", "DESC")->get();
            $today = date('Y-m-d');
            foreach ($dataWareHouseSalesOrder as $key => $value) {
                $dataMartMarketPlace = DataMartMarketPlace::where("transaction_date", $value->transaction_date)
                                    ->where("channel_name", $value->channel_name)->first();

                if($dataMartMarketPlace == null){
                    Log::info('Insert Channel : ' . $value->channel_name. ' and Transaction Date : '. $value->transaction_date);
                    $newDataMartMarketPlace = new DataMartMarketPlace();
                    $newDataMartMarketPlace->channel_id =  $value->channel_id;
                    $newDataMartMarketPlace->channel_name =  $value->channel_name;
                    $newDataMartMarketPlace->store_name =  $value->store_name;
                    $newDataMartMarketPlace->transaction_date =  $value->transaction_date;
                    $newDataMartMarketPlace->grand_total =  $value->total;
                    $newDataMartMarketPlace->sync_date =   $today;

                    $newDataMartMarketPlace->save(); 
                }

                if($dataMartMarketPlace != null){
                    Log::info('Update Channel : ' . $value->channel_name. ' and Transaction Date : '. $value->transaction_date);
                    $dataMartMarketPlace->channel_id =  $value->channel_id;
                    $dataMartMarketPlace->channel_name =  $value->channel_name;
                    $dataMartMarketPlace->store_name =  $value->store_name;
                    $dataMartMarketPlace->transaction_date =  $value->transaction_date;
                    $dataMartMarketPlace->grand_total =  $value->total;
                    $dataMartMarketPlace->sync_date =   $today;

                    $dataMartMarketPlace->save(); 
                }
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function syncBasketSize(){
        try{
            // Formula
            // Basket Size : SUM Grand Total dalam 1 hari / Jumlah Nomor Order dalam 1 hari

            $dataWareHouseSalesOrder =  DB::table("data_ware_house_orders")
                                        ->select("transaction_date", DB::raw("COUNT(salesorder_no) as total_order_number"), DB::raw("SUM(grand_total) as grand_total"));

            $dataWareHouseSalesOrder =  $dataWareHouseSalesOrder->groupBy("transaction_date")
                                        ->orderBy("transaction_date", "ASC")->get();
            $today = date('Y-m-d');

            foreach ($dataWareHouseSalesOrder as $key => $value) {
                $basketSize = BasketSizeReport::where("transaction_date", $value->transaction_date)->first();

                if($basketSize == null){
                    Log::info('Insert Basket Size with Transaction Date : '. $value->transaction_date);
                    $newBasketSize = new BasketSizeReport();
                    $newBasketSize->transaction_date = $value->transaction_date;
                    $newBasketSize->total_order_number = $value->total_order_number;
                    $newBasketSize->grand_total = $value->grand_total;
                    $newBasketSize->result_divide = ($value->grand_total / $value->total_order_number);
                    $newBasketSize->sync_date =  $today;

                    $newBasketSize->save();
                }

                if($basketSize != null){
                    Log::info('Update Basket Size with Transaction Date : '. $value->transaction_date);
                    $basketSize->total_order_number = $value->total_order_number;
                    $basketSize->grand_total = $value->grand_total;
                    $basketSize->result_divide = ($value->grand_total / $value->total_order_number);
                    
                    $basketSize->save();
                }
              
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // Best Top 10 Product
    public function syncBestProduct(){
        try{
            $bestProduct = DB::table("data_ware_house_order_details")
                            ->select("data_ware_house_order_details.sku_id", "data_ware_house_order_details.sku_code", DB::raw("SUM(data_ware_house_order_details.qty_in_base) as qty_sold"));
            $bestProduct = $bestProduct->groupBy("data_ware_house_order_details.sku_code", "data_ware_house_order_details.sku_id")
                            ->orderBy("qty_sold", "DESC")->get(); 
                            
            $today = date('Y-m-d');

            foreach ($bestProduct as $key => $value) {
                $dataMartProductDetail = DataMartProductDetail::where("sku_code", $value->sku_code)->first();
                $product = Product::where("sku", $value->sku_code)->where("id", $value->sku_id)->first();
               
                if($dataMartProductDetail == null){
                    Log::info('Insert Best Product with SKU : ' . $value->sku_code);
                    $newDataMartProductDetail = new DataMartProductDetail();
                    $newDataMartProductDetail->sku_id =  $product['id'];
                    $newDataMartProductDetail->sku_code = $product['sku'];
                    $newDataMartProductDetail->name = $product['name'];

                    if($product['article'] != null){
                        $newDataMartProductDetail->product_name = $product['article'];
                    } else {
                        $newDataMartProductDetail->product_name = $product['name'];
                    }

                    $newDataMartProductDetail->qty_sold = $value->qty_sold;
                    $newDataMartProductDetail->sync_date = $today;

                    $newDataMartProductDetail->save();
                } 

                if($dataMartProductDetail != null){
                    Log::info('Update Best Product with SKU : ' . $value->sku_code);
                    
                    $dataMartProductDetail->sku_code = $product['sku'];
                    $dataMartProductDetail->name = $product['name'];

                    if($product['article'] != null){
                        $dataMartProductDetail->product_name = $product['article'];
                    } else {
                        $dataMartProductDetail->product_name = $product['name'];
                    }
                    $dataMartProductDetail->qty_sold = $value->qty_sold;
                    $dataMartProductDetail->sync_date = $today;

                    $dataMartProductDetail->save();
                }
            }
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function syncSellThrough(){
        try{
            // Formula
            // X (%) = ( Qty Barang Terjual / Qty Barang Masuk) * 100%
            $dataSellThrough =   DB::table("data_ware_house_order_details")
                            ->join("item_stocks", "data_ware_house_order_details.sku_code", "=", "item_stocks.sku_code")
                            ->select("item_stocks.sku_code", DB::raw("COALESCE(SUM(data_ware_house_order_details.qty_in_base), 0) as total_units_sold"), "item_stocks.qty as unit_stock" );

            $dataSellThrough = $dataSellThrough->groupBy("item_stocks.sku_code", "item_stocks.qty")
                                ->orderBy("total_units_sold", "DESC")->get();

            $today = date('Y-m-d');
            $sellThrough = null;

            foreach ($dataSellThrough as $key => $value) {

                $dataMartSellThrough = DataMartSellThrough::where("sku_code", $value->sku_code)->where("sync_date")->first();
                $product = Product::where("sku", $value->sku_code)->first();

                if((int) $value->unit_stock <= 0){
                    $sellThrough = null;
                } else {
                    $sellThrough = ( (int) $value->total_units_sold / (int) $value->unit_stock) * 100;
                }
            
                if($dataMartSellThrough == null){
                    Log::info('Insert Sell Through with SKU : ' . $value->sku_code);
                    $newDataMartSellThrough = new DataMartSellThrough();
                    $newDataMartSellThrough->sku_code = $value->sku_code;
                 
                    if($product->article == null){
                        $newDataMartSellThrough->product_name = $product->name; 
                    } else {
                        $newDataMartSellThrough->product_name = $product->article; 
                    }

                    $newDataMartSellThrough->total_unit_received =  (int) $value->unit_stock;
                    $newDataMartSellThrough->total_unit_sold = (int) $value->total_units_sold;
                    $newDataMartSellThrough->sell_through =  $sellThrough;
                    $newDataMartSellThrough->sync_date = $today = date('Y-m-d');
                    $newDataMartSellThrough->name = $product->name;

                    $newDataMartSellThrough->save();
                }

                if($dataMartSellThrough != null){
                    Log::info('Update Sell Through with SKU : ' .$value->sku_code);
                   
                    if($product->article == null){
                        $dataMartSellThrough->product_name = $product->name; 
                    } else {
                        $dataMartSellThrough->product_name = $product->article; 
                    }
                    $dataMartSellThrough->total_unit_received = (int) $value->unit_stock;
                    $dataMartSellThrough->total_unit_sold =  (int) $value->total_units_sold;
                    $dataMartSellThrough->sell_through =  $sellThrough;
                    $dataMartSellThrough->name = $product->name;
                    $dataMartSellThrough->sync_date = $today = date('Y-m-d');

                    $dataMartSellThrough->save();
                }
            }
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function syncSaleStockRatio(){
        try{
            // Formula
            // X (Rp)= Omset Penjualan (akhir bulan) / Nilai Inventory Keseluruhan dalam rupiah (dari harga jual) dari data gudang
            // Omset Penjualan = SUM(Grand Total dari Invoice)
            // Nilai Inventory = SUM ((Total Stock Per Item x Harga Jual Per Item))
            $today = date('Y-m-d');
            // Get inventory value then store to data mart
            $getInventoryValueSaleStockRatio = $this->getInventoryValueSaleStockRatio($today);
            
            // Calculate or SUM total inventory value then Store to report sale stock ratio
            $totalInventoryValue = $this->totalInventoryValue($today);

            // Calculate or SUM Total Sales Turn Over (Omset)
            $totalSalesTurnOver = $this->totalSalesTurnOver($today);

            //$ssr = $this->calculateSSR($today);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // Get Inventory Value For SSR (Sell Stock Ratio)
    public function getInventoryValueSaleStockRatio($today){
        try{
            // Get Inventory Value
            $dataValueInventory =  DB::table("data_ware_house_order_details")
                                    ->join("item_stocks", "data_ware_house_order_details.sku_code", "=", "item_stocks.sku_code")
                                    ->join("data_ware_house_orders", "data_ware_house_order_details.dwh_order_id", "=", "data_ware_house_orders.id")
                                    ->select("data_ware_house_orders.transaction_date", "data_ware_house_orders.salesorder_no",  "data_ware_house_order_details.dwh_order_id", "data_ware_house_order_details.sku_code", "item_stocks.qty as total_stock", "data_ware_house_order_details.amount" , DB::raw("item_stocks.qty * data_ware_house_order_details.amount  as total_inventory"));
                
            $dataValueInventory =  $dataValueInventory->orderBy("data_ware_house_order_details.dwh_order_id", "ASC")->get();  
            // Store to data mart
            foreach ($dataValueInventory as $key => $value) {
                $dataMartSaleStockRatio = DataMartSaleStockRatio::where("transaction_date", $value->transaction_date)
                                            ->where("salesorder_no", $value->salesorder_no)
                                            ->where("dwh_order_id", $value->dwh_order_id)
                                            ->where("sku_code", $value->sku_code)->first();
                if($dataMartSaleStockRatio == null){
                    Log::info('Insert Data Mart Inventory Value with SKU : ' . $value->sku_code . ' - Order Number : ' . $value->salesorder_no . ' Date : ' . $value->transaction_date);
                    $newDataMartSaleStockRatio = new DataMartSaleStockRatio();
                    $newDataMartSaleStockRatio->transaction_date = $value->transaction_date;
                    $newDataMartSaleStockRatio->sku_code =  $value->sku_code;
                    $newDataMartSaleStockRatio->sync_date =  $today;
                    $newDataMartSaleStockRatio->salesorder_no =  $value->salesorder_no;
                    $newDataMartSaleStockRatio->dwh_order_id = $value->dwh_order_id;
                    $newDataMartSaleStockRatio->total_stock = $value->total_stock;
                    $newDataMartSaleStockRatio->amount = $value->amount;
                    $newDataMartSaleStockRatio->total_inventory = $value->total_inventory;
                        
                    $newDataMartSaleStockRatio->save();
                }

                if($dataMartSaleStockRatio != null){
                    Log::info('Update Data Mart Inventory Value with SKU : ' . $value->sku_code . ' - Order Number : ' . $value->salesorder_no . ' Date : ' . $value->transaction_date);
                    $dataMartSaleStockRatio->sync_date =  $today = date('Y-m-d');
                    $dataMartSaleStockRatio->salesorder_no = $value->salesorder_no;
                    $dataMartSaleStockRatio->dwh_order_id = $value->dwh_order_id;
                    $dataMartSaleStockRatio->total_stock = $value->total_stock;
                    $dataMartSaleStockRatio->amount =$value->amount;
                    $dataMartSaleStockRatio->total_inventory = $value->total_inventory;

                    $dataMartSaleStockRatio->save();
                }
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
    
    // SUM of Inventory Value For SSR (Sell Stok Ratio)
    public function totalInventoryValue($today){
        try{
            $totalInventoryValue = DB::table("data_mart_sale_stock_ratios")
                                    ->select("transaction_date",  DB::raw("SUM(total_inventory) as total_inventory"));
            $totalInventoryValue = $totalInventoryValue->groupBy("transaction_date")->get();

            foreach ($totalInventoryValue as $key => $value) {
                $dataReportSellStockRatio = SellStockRatioReport::where("transaction_date", $value->transaction_date)->first();

                if($dataReportSellStockRatio == null){
                    Log::info('Insert Inventory Value to Report Sell Stock Ratio with transaction date : '.$value->transaction_date. ' and total inventory value : ' . $value->total_inventory);
                    $newReportInventoryValue = new SellStockRatioReport();
                    $newReportInventoryValue->transaction_date = $value->transaction_date;
                    $newReportInventoryValue->total_inventory_value = $value->total_inventory;
                    $newReportInventoryValue->sync_date = $today;
                    $newReportInventoryValue->save();
                }

                if($dataReportSellStockRatio != null){
                    Log::info('Update Inventory Value to Report Sell Stock Ratio with transaction date : '.$value->transaction_date. ' and total inventory value : ' . $value->total_inventory_value);
                    $dataReportSellStockRatio->total_inventory_value = $value->total_inventory;
                    $dataReportSellStockRatio->total_sales_turn_over = $dataReportSellStockRatio->total_sales_turn_over;
                    $dataReportSellStockRatio->sync_date = $today;
                    $dataReportSellStockRatio->save();
                }
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    // Amount of Grand Total From Grand Total For SSR (Sell Stok Ratio)
    public function totalSalesTurnOver($today){
        try{
            $totalOmset = DB::table("data_ware_house_orders")
                        ->select("transaction_date",  DB::raw("SUM(grand_total) as amount"));
            $totalOmset = $totalOmset->groupBy("transaction_date")->get();

            foreach ($totalOmset as $key => $value) {
                $dataReportSellStockRatio = SellStockRatioReport::where("transaction_date", $value->transaction_date)->first();

                if($dataReportSellStockRatio == null){
                    Log::info('Insert Omset to Report Sell Stock Ratio with transaction date : '.$value->transaction_date. ' and amount of grand total : ' . $value->amount);
                    $newReportAmountGrandTotal = new SellStockRatioReport();
                    $newReportAmountGrandTotal->transaction_date = $value->transaction_date;
                    $newReportAmountGrandTotal->total_sales_turn_over = $value->amount;
                    $newReportInventoryValue->sell_stock_ratio = $value->amount /  $dataReportSellStockRatio->total_inventory_value;
                    $newReportAmountGrandTotal->save();
                }

                if($dataReportSellStockRatio!= null){
                    Log::info('Update Omset to Report Sell Stock Ratio with transaction date : '.$value->transaction_date. ' and amount of grand total : ' . $value->amount);
                    $newReportAmountGrandTotal = new SellStockRatioReport();
                    $dataReportSellStockRatio->total_sales_turn_over = $value->amount;
                    $dataReportSellStockRatio->total_inventory_value = $dataReportSellStockRatio->total_inventory_value;
                    $dataReportSellStockRatio->sell_stock_ratio = $value->amount /  $dataReportSellStockRatio->total_inventory_value;
                    $dataReportSellStockRatio->save();
                }
            }
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function calculateSSR($today){
        try{
            $reportSSR = SellStockRatioReport::all();
            foreach ($reportSSR as $key => $value) {
                $dataReportSSR = SellStockRatioReport::where("transaction_date", $value->transaction_date)->first();
                $dataReportSSR->transaction_date = $dataReportSSR->transaction_date;
                $dataReportSSR->total_sales_turn_over = $dataReportSSR->total_sales_turn_over;
                $dataReportSSR->total_inventory_value = $dataReportSSR->total_inventory_value;
                $dataReportSSR->sell_stock_ratio = $dataReportSSR->total_sales_turn_over / $dataReportSSR->total_inventory_value;
                $dataReportSSR->sync_date = $today;
                $dataReportSSR->save();
            }
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }