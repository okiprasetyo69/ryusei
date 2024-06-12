<?php

namespace App\Services\Repositories;

use App\Models\DataWareHouseOrder;
use App\Models\DataWareHouseOrderDetail;
use App\Models\SalesChannel;
use App\Models\Product;
use App\Models\User;
use App\Services\Interfaces\DataWarehouseSalesOrderService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

/**
 * Class DataWarehouseSalesOrderRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.05.13
 * 
 *
 * @package namespace App\Services\Repositories;
*/

class DataWarehouseSalesOrderRepositoryEloquent implements DataWarehouseSalesOrderService {

    /**
    * @var DataWareHouseOrder
    */
    private DataWareHouseOrder $dataWarehouseOrder;

     /**
    * @var DataWareHouseOrderDetail
    */
    private DataWareHouseOrderDetail $dataWarehouseOrderDetail;

    public function __construct(DataWareHouseOrder $dataWarehouseOrder, DataWareHouseOrderDetail $dataWarehouseOrderDetail)
    {
        $this->dataWarehouseOrder = $dataWarehouseOrder;
        $this->dataWarehouseOrderDetail = $dataWarehouseOrderDetail;
    }

    public function getDataWareHouseSalesOrder(Request $request){
        try{
            
            $dataWarehouseOrder =  $this->dataWarehouseOrder::with('channel')->orderBy('transaction_date', 'DESC');
          
            if($request->invoice_number != null){
                $dataWarehouseOrder = $dataWarehouseOrder->where("invoice_number", "like", "%" . $request->invoice_number. "%");
            }

            if($request->start_date != null){
                $dataWarehouseOrder = $dataWarehouseOrder->where("transaction_date", ">=", $request->start_date);
            }

            if($request->end_date != null){
                $dataWarehouseOrder = $dataWarehouseOrder->where("transaction_date", "<=", $request->end_date);
            }

            $dataWarehouseOrder = $dataWarehouseOrder->get();

            $datatables = Datatables::of($dataWarehouseOrder);
            return $datatables->make( true );
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detailSalesOrderCompleted(Request $request){
        try{
            $dataWarehouseSalesOrderCompletedDetail = DataWareHouseOrderDetail::orderBy("id", "ASC");

            if($request->dwh_order_id != null){
                $dataWarehouseSalesOrderCompletedDetail = $dataWarehouseSalesOrderCompletedDetail->where("dwh_order_id", $request->dwh_order_id);
            }

            $dataWarehouseSalesOrderCompletedDetail = $dataWarehouseSalesOrderCompletedDetail->get();
           
            $datatables = Datatables::of($dataWarehouseSalesOrderCompletedDetail);

            return $datatables->make( true );

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getDataWareHouseOrderFromJubelio($userData, $transactionDateFrom, $transactionDateTo){
        try{
            // String date ISO UTC
            $transactionDateFrom = $transactionDateFrom."T17%3A00%3A00.000Z";
            $transactionDateTo = $transactionDateTo."T16%3A59%3A00.000Z&q=";
            $firstPage = 1;
            $pageSize = 200;
            $today = date('Y-m-d');

            $responses = $this->endPointSalesOrderTransaction($userData, $firstPage,  $pageSize, $transactionDateFrom, $transactionDateTo);
            
            if($responses->status() == 200){
                $totalData = $responses->json()['totalCount'];
                $totalPage = ceil($totalData /  $pageSize) + 10;
                for($i = 0; $i <= $totalPage; $i++) { 
                    Log::info("Loop Response page : ". $firstPage);

                    $respons = $this->endPointSalesOrderTransaction($userData, $firstPage,  $pageSize, $transactionDateFrom, $transactionDateTo);
                    $firstPage = $firstPage + 1;

                    if($respons->status() == 200){  
                        $data = $respons->json()['data'];
                        foreach ($data as $key => $value) {
                            $dataWarehouseOrder =  $this->dataWarehouseOrder::where("salesorder_id", $value['salesorder_id'])
                                                    ->where("salesorder_no", $value['salesorder_no'])->first();
                            $channel = SalesChannel::where("name" , $value['channel_name'])->first();
                            $channelId = null;
                            $channelName = "";
                            if($dataWarehouseOrder == null){
                                Log::info('Insert Order Trx with Sales Order Number : ' .$value['salesorder_no'] . ' and Invoice Number : '.$value['invoice_no']);
                              
                                if($channel != null){
                                    $channelId = $channel->id;
                                    $channelName =  $channel->name;
                                }

                                DataWareHouseOrder::create([
                                    'salesorder_id' => $value['salesorder_id'],
                                    'salesorder_no' =>  $value['salesorder_no'],
                                    'invoice_number' =>  $value['invoice_no'],
                                    'invoice_created_date' => date_create($value['invoice_created_date'])->format('Y-m-d'),
                                    'transaction_date' => date_create($value['transaction_date'])->format('Y-m-d'),
                                    'is_paid' => $value['is_paid'],
                                    'shipping_full_name' =>$value['shipping_full_name'],
                                    'customer_name' => $value['customer_name'],
                                    'grand_total' => $value['grand_total'],
                                    'store_name' => $value['store_name'],
                                    'channel_id' => $channelId,
                                    'channel_name' =>  $channelName,
                                    'shipper' => $value['shipper'],
                                    'store' => $value['store'],
                                    'package_count' => $value['package_count'],
                                    'wms_status' => $value['wms_status'],
                                    'note' => $value['note'],
                                    'ref_no' => $value['ref_no'],
                                    'tracking_number' => $value['tracking_number'],
                                    'is_cod' => $value['is_cod'],
                                    'sync_date' => $today,
                                ]);
                            }

                            if($dataWarehouseOrder != null){
                                Log::info('Sales Order Number : ' .$value['salesorder_no'] . ' was Exist');
                            }
                        }
                    }
                }
            }

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            Log::info("Error Code : ". $ex->getCode());
            return false;
        }
    }

    public function getDataWareHouseDetailOrderTransaction($userData, $transactionDateFrom, $transactionDateTo){
        try{
            $arrSalesOrder = [];
            $dwhSalesOrder =  $this->dataWarehouseOrder::where("transaction_date" , ">=",  $transactionDateFrom)
                                ->where("transaction_date" , "<=",  $transactionDateTo)->get();
            $today = date('Y-m-d');
            foreach ($dwhSalesOrder as $key => $value) {
                array_push($arrSalesOrder, [
                    'salesorder_id' => $value['salesorder_id'],
                ]);
            }
            foreach ($arrSalesOrder as $k => $val) {
                Log::info('Get detail sales order with ID : ' . $val['salesorder_id']);

                $dwhOrder =  $this->dataWarehouseOrder::where("salesorder_id", $val['salesorder_id'])->first();
                $responses = $this->endPointDetailSalesOrderTransaction($userData,  $val);
       
                if($responses->status() == 200){
                    
                    // update sales order completed
                    $dataSalesOrderCompleted = DataWareHouseOrder::where("salesorder_id", $val['salesorder_id'])->first();
                   
                    if($dataSalesOrderCompleted != null){
                        Log::info('Update Order Trx with Sales Order ID : ' . $val['salesorder_id']);

                        $dataSalesOrderCompleted->sub_total = $responses->json()['sub_total'];
                        $dataSalesOrderCompleted->total_disc = $responses->json()['total_disc'];
                        $dataSalesOrderCompleted->total_tax = $responses->json()['total_tax'];
                        $dataSalesOrderCompleted->payment_method = $responses->json()['payment_method'];
                        $dataSalesOrderCompleted->service_fee = $responses->json()['service_fee'];
                        $dataSalesOrderCompleted->insurance_cost = $responses->json()['insurance_cost'];
                        $dataSalesOrderCompleted->shipping_cost = $responses->json()['shipping_cost'];
                        $dataSalesOrderCompleted->buyer_shipping_cost = $responses->json()['buyer_shipping_cost'];
                        $dataSalesOrderCompleted->add_disc = $responses->json()['add_disc'];
                        $dataSalesOrderCompleted->add_fee = $responses->json()['add_fee'];
                        $dataSalesOrderCompleted->discount_marketplace = $responses->json()['discount_marketplace'];
                        $dataSalesOrderCompleted->total_amount_mp = $responses->json()['total_amount_mp'];
                        $dataSalesOrderCompleted->save();
                    }
                    // upsert sales order detail completed
                    $data = $responses->json()['items'];
                    foreach ($data as $key => $value) {
                        $detailOrder = $this->dataWarehouseOrderDetail::where("dwh_order_id", $dwhOrder->id)
                                        ->where("sku_code", $value['item_code'])->first();
                        $product = Product::where("sku", $value['item_code'])->first();
                        $productId = null;
                        $skuCode = null;
                        $productName = null;
                        if($detailOrder == null){
                            Log::info('Create Detail Sales Order Id '. $dwhOrder->id);
                            if($product != null){
                                $productId = $product->id;
                                $skuCode = $product->sku;
                                $productName = $product->name;
                            }
                            DataWareHouseOrderDetail::create(
                                [
                                    'dwh_order_id' =>  $dwhOrder->id,
                                    'sku_id' =>    $productId,
                                    'sku_code' =>  $skuCode,
                                    'name' =>    $productName,
                                    'tax_id' =>   $value['tax_id'],
                                    'disc_marketplace' =>   $value['disc_marketplace'],
                                    'price' =>  $value['price'],
                                    'qty' =>  $value['qty'],
                                    'unit' =>  $value['unit'],
                                    'qty_in_base' =>   $value['qty_in_base'],
                                    'discount' =>   $value['disc'],
                                    'disc_amount' =>  $value['disc_amount'],
                                    'amount' =>  $value['amount'],
                                    'tax_amount' =>   $value['tax_amount'],
                                    'shipped_date' =>   $value['shipped_date'],
                                    'is_bundle' =>  $value['is_bundle'],
                                    'description' =>  $value['description'],
                                    'sell_price' =>  $value['sell_price'],
                                    'original_price' =>   $value['original_price'],
                                    'rate' =>  $value['rate'],
                                    'tax_name' =>   $value['tax_name'],
                                    'qty_picked' =>  $value['qty_picked'],
                                    'sync_date' => $today,
                                ]
                            );
                        }

                        if($detailOrder != null){
                            Log::info('Order Detail '.$dwhOrder->id.' was Exist');
                        }
                    }
                }
            }

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            Log::info("Error Code : ". $ex->getCode());
            return false;
        }
    }
    
    public function endPointSalesOrderTransaction($userData, $firstPage, $pageSize, $transactionDateFrom, $transactionDateTo){
        $responses = Http::timeout(10)->retry(5, 3000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/sales/orders/completed/?page='.$firstPage.'&pageSize='.$pageSize.'&transactionDateFrom='.$transactionDateFrom.'&transactionDateTo='.$transactionDateTo);
        return $responses;
    }

    public function endPointDetailSalesOrderTransaction($userData , $val){
        $responses = Http::timeout(10)->retry(5, 3000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/sales/orders/'. $val['salesorder_id']);
        return $responses;
    }

    public function getTotalSalesOrderCompleted(Request $request){
        try{
            $totalSalesOrder = DB::table("data_ware_house_orders")->select(DB::raw("COUNT(*) as total_order"))->first();
            return response()->json([
                'status' => 200,
                'message' => "Success get total order !",
                'data' => $totalSalesOrder 
            ]); 
           
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function updateTokenApi($userData){
        try{

            $users =  User::find($userData['id'])->first();
            $loginUser =  Http::post(env('JUBELIO_API') . '/login', [
                'email' => env('JUBELIO_EMAIL'),
                'password' => env('JUBELIO_PASSWORD')
            ]);
            
            if($loginUser->status() == 200){
                $userLogin = $loginUser->json();
                $users->api_token = $userLogin['token'];
            } 

            $users->save();

            return $user;
        
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}   