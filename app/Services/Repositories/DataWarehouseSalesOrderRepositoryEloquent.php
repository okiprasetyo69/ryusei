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

            if($responses->status() == 401){
                $relogin =  $this->updateTokenApi($userData);
            }

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
                            
                            if($dataWarehouseOrder == null){
                                Log::info('Insert Order Trx with Sales Order Number : ' .$value['salesorder_no'] . ' and Invoice Number : '.$value['invoice_no']);
                                $newOrderData = new DataWareHouseOrder();
                                $newOrderData->salesorder_id = $value['salesorder_id'];
                                $newOrderData->salesorder_no = $value['salesorder_no'];
                                $newOrderData->invoice_number = $value['invoice_no'];
                                $newOrderData->invoice_created_date =  date_create($value['invoice_created_date'])->format('Y-m-d');
                                $newOrderData->transaction_date = date_create($value['transaction_date'])->format('Y-m-d');
                                $newOrderData->is_paid = $value['is_paid'];
                                $newOrderData->shipping_full_name = $value['shipping_full_name'];
                                $newOrderData->customer_name = $value['customer_name'];
                                $newOrderData->grand_total = $value['grand_total'];
                                $newOrderData->store_name = $value['store_name'];
                                if($channel != null){
                                    $newOrderData->channel_id =  $channel->id;
                                    $newOrderData->channel_name = $channel->name;
                                }
                                $newOrderData->shipper = $value['shipper'];
                                $newOrderData->store = $value['store'];
                                $newOrderData->package_count = $value['package_count'];
                                // $newOrderData->cancel_reason = $value['cancel_reason'] == false ? 0 : 1 ;
                                // $newOrderData->cancel_reason_detail = $value['cancel_reason_detail' == false ? 0 : 1];
                                $newOrderData->wms_status = $value['wms_status'];
                                $newOrderData->note = $value['note'];
                                $newOrderData->ref_no = $value['ref_no'];
                                $newOrderData->tracking_number = $value['tracking_number'];
                                $newOrderData->is_cod = $value['is_cod'];
                                $newOrderData->sync_date =  $today;

                                $newOrderData->save();
                            }

                            if($dataWarehouseOrder != null){
                                Log::info('Update Order Trx with Sales Order Number : ' .$value['salesorder_no'] . ' and Invoice Number : '.$value['invoice_no']);
                                $dataWarehouseOrder->invoice_created_date =  date_create($value['invoice_created_date'])->format('Y-m-d');
                                $dataWarehouseOrder->transaction_date = date_create($value['transaction_date'])->format('Y-m-d');
                                $dataWarehouseOrder->is_paid = $value['is_paid'];
                                $dataWarehouseOrder->shipping_full_name = $value['shipping_full_name'];
                                $dataWarehouseOrder->customer_name = $value['customer_name'];
                                $dataWarehouseOrder->grand_total = $value['grand_total'];
                                $dataWarehouseOrder->store_name = $value['store_name'];
                                if($channel != null){
                                    $dataWarehouseOrder->channel_id =  $channel->id;
                                    $dataWarehouseOrder->channel_name = $channel->name;
                                }
                                $dataWarehouseOrder->shipper = $value['shipper'];
                                $dataWarehouseOrder->store = $value['store'];
                                $dataWarehouseOrder->package_count = $value['package_count'];
                                // $dataWarehouseOrder->cancel_reason = $value['cancel_reason'];
                                // $dataWarehouseOrder->cancel_reason_detail = $value['cancel_reason_detail'];
                                $dataWarehouseOrder->wms_status = $value['wms_status'];
                                $dataWarehouseOrder->note = $value['note'];
                                $dataWarehouseOrder->ref_no = $value['ref_no'];
                                $dataWarehouseOrder->tracking_number = $value['tracking_number'];
                                $dataWarehouseOrder->is_cod = $value['is_cod'];
                               
                                $dataWarehouseOrder->save();
                            }
                        }
                    }
                }
            }

            return response()->json([
                'status' => 200,
                'message' => "Success sync data order !",
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            Log::info("Error Code : ". $ex->getCode());
            if($ex->getCode() == 0  || $ex->getCode() == 404 ){
                $responses = $this->endPointSalesOrderTransaction($userData,  $firstPage,  $pageSize, $transactionDateFrom, $transactionDateTo);
                Log::info("Retry on process ... ");
            }
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
                    $dataSalesOrderCompleted = DataWareHouseOrder::where("salesorder_id",  $val['salesorder_id'])->first();
                    if($dataSalesOrderCompleted != null){
                        Log::info('Update Order Trx with Sales Order ID : ' .$value['salesorder_id']);
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
                        if($detailOrder == null){
                            Log::info('Create DWH Order Detail with SKU Code - ' .  $value['item_code']);
                            $newDetailOrder = new DataWareHouseOrderDetail();
                            $newDetailOrder->dwh_order_id =  $dwhOrder->id;
                            if($product != null){
                                $newDetailOrder->sku_id = $product->id;
                                $newDetailOrder->sku_code = $product->sku;
                                $newDetailOrder->name = $product->name;
                            }
                            $newDetailOrder->tax_id = $value['tax_id'];
                            $newDetailOrder->disc_marketplace = $value['disc_marketplace'];
                            $newDetailOrder->price = $value['price'];
                            $newDetailOrder->qty = $value['qty'];
                            $newDetailOrder->unit = $value['unit'];
                            $newDetailOrder->qty_in_base = $value['qty_in_base'];
                            $newDetailOrder->discount = $value['disc'];
                            $newDetailOrder->disc_amount = $value['disc_amount'];
                            $newDetailOrder->tax_amount = $value['tax_amount'];
                            $newDetailOrder->amount = $value['amount'];
                            $newDetailOrder->shipped_date =  date_create($value['shipped_date'])->format('Y-m-d');
                            $newDetailOrder->is_bundle = $value['is_bundle'];
                            $newDetailOrder->description = $value['description'];
                            $newDetailOrder->sell_price = $value['sell_price'];
                            $newDetailOrder->original_price = $value['original_price'];
                            $newDetailOrder->rate = $value['rate'];
                            $newDetailOrder->tax_name = $value['tax_name'];
                            $newDetailOrder->qty_picked = $value['qty_picked'];
                            $newDetailOrder->sync_date = $today;

                            $newDetailOrder->save();
                        }

                        if($detailOrder != null){
                            Log::info('Update DWH Order Detail with SKU Code - ' .  $value['item_code']);

                            if($product != null){
                                $detailOrder->sku_id = $product->id;
                                $detailOrder->sku_code = $product->sku;
                                $detailOrder->name = $product->name;
                            }
                            $detailOrder->tax_id = $value['tax_id'];
                            $detailOrder->disc_marketplace = $value['disc_marketplace'];
                            $detailOrder->price = $value['price'];
                            $detailOrder->qty = $value['qty'];
                            $detailOrder->unit = $value['unit'];
                            $detailOrder->qty_in_base = $value['qty_in_base'];
                            $detailOrder->discount = $value['disc'];
                            $detailOrder->disc_amount = $value['disc_amount'];
                            $detailOrder->tax_amount = $value['tax_amount'];
                            $detailOrder->amount = $value['amount'];
                            $detailOrder->shipped_date =  date_create($value['shipped_date'])->format('Y-m-d');
                            $detailOrder->is_bundle = $value['is_bundle'];
                            $detailOrder->description = $value['description'];
                            $detailOrder->sell_price = $value['sell_price'];
                            $detailOrder->original_price = $value['original_price'];
                            $detailOrder->rate = $value['rate'];
                            $detailOrder->tax_name = $value['tax_name'];
                            $detailOrder->qty_picked = $value['qty_picked'];

                            $detailOrder->save();
                        }
                    }

                    return response()->json([
                        'status' => 200,
                        'message' => 'Success sync Sales Order Completed !',
                    ]); 
                }
            }

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            Log::info("Error Code : ". $ex->getCode());
            if($ex->getCode() == 0  || $ex->getCode() == 404 ){
                Log::info("Retry on process ... ");
                $responses = $this->endPointDetailSalesOrderTransaction($userData,  $val);
            }
            return false;
        }
    }
    
    public function endPointSalesOrderTransaction($userData, $firstPage, $pageSize, $transactionDateFrom, $transactionDateTo){
        $responses = Http::timeout(10)->retry(3, 1000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/sales/orders/completed/?page='.$firstPage.'&pageSize='.$pageSize.'&transactionDateFrom='.$transactionDateFrom.'&transactionDateTo='.$transactionDateTo);
        return $responses;
    }

    public function endPointDetailSalesOrderTransaction($userData , $val){
        $responses = Http::timeout(10)->retry(3, 1000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/sales/orders/'.$val['salesorder_id']);
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