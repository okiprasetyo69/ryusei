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

    public function reportBestProduct(Request $request){
        try{
            $limit = 10;
            $bestProduct = DataMartProductDetail::orderBy('qty_sold', 'DESC');

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

            $bestProduct =  $bestProduct->take($limit)->get();
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

    public function reportSaleStockRatio(Request $request){
        try{
            return true;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function reportSellThrough(Request $request){
        try{
            $reportSellThrough = DataMartSellThrough::orderBy("sync_date", "DESC");
            
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
            $reportSellThrough = $reportSellThrough->get();
            $datatables = Datatables::of($reportSellThrough);
            return $datatables->make(true);
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

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
            // Basket Size : Total Grand Total dalam 1 hari / Jumlah Nomor Order dalam 1 hari

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

    public function saleStockRatio(){
        try{
            // Formula
            // X (Rp)= Omset Penjualan (akhir bulan) / Nilai Inventory Keseluruhan dalam rupiah (dari harga jual) dari data gudang
          

            $today = date('Y-m-d');

        }catch(Exception $ex){
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
   
 }