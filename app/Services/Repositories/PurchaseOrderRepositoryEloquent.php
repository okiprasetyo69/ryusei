<?php

namespace App\Services\Repositories;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Services\Constants\SalesInvoiceConstantInterface;
use App\Services\Constants\WarehouseConstantInterface;
use App\Services\Interfaces\PurchaseOrderService;

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
 * Class PurchaseOrderRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.05.07
 * 
 *
 * @package namespace App\Services\Repositories;
 */


 class PurchaseOrderRepositoryEloquent implements PurchaseOrderService{

    /**
    * @var PurchaseOrder
    */

    private PurchaseOrder $purchaseOrder;

    public function __construct(PurchaseOrder $purchaseOrder)
    {
        $this->purchaseOrder = $purchaseOrder;
    }

    public function getPurchaseOrder(Request $request){
        try{
            $purchaseOrder = $this->purchaseOrder::with('vendor')->orderBy('date', 'ASC');
            $purchaseOrder = $purchaseOrder->get();

            $datatables = Datatables::of($purchaseOrder);
            return $datatables->make( true );

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function purchaseOrderDetail(Request $request){
        try{
            $purchaseOrderDetail = PurchaseOrderDetail::with("unit")->where("purchase_id", $request->purchase_id)->get();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $purchaseOrderDetail
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function updatePurchaseOrderSync($userData){
        try{

            $responses = Http::withHeaders([
                'Authorization' => 'Bearer ' . $userData['api_token'],
                'Accept' => 'application/json', 
            ])->get(env('JUBELIO_API') . '/purchase/orders/');

            if($responses->status() == 401){
                $relogin = $this->updateTokenApi($userData);
            }

            if($responses->status() == 200){
                $data = $responses->json()['data'];
                foreach ($data as $key => $value) {

                    $purchaseInvoice = PurchaseOrder::where("purchaseorder_number", $value['purchaseorder_no'])->first();
                    $supplier = Vendor::where("name", $value['supplier_name'])->first();
                    $convertTransactionDate = date_create($value['transaction_date'])->format('Y-m-d');
                   
                    Log::info('Upsert Purchase Order Number - ' .   $value['purchaseorder_no']);
                    if($purchaseInvoice == null){

                        $newPurchaseOrder = new PurchaseOrder();
                        $newPurchaseOrder->purchaseorder_number = $value['purchaseorder_no'];
                        $newPurchaseOrder->vendor_id = $supplier->id;
                        $newPurchaseOrder->transaction_date = $convertTransactionDate ;
                        $newPurchaseOrder->grand_total = $value['grand_total'];
                        $newPurchaseOrder->note = $value['note'];
                        $newPurchaseOrder->vendor_reference = $value['ref_no'];
                        $newPurchaseOrder->bills = $value['bills'];
                        $newPurchaseOrder->purchaseorder_id = $value['purchaseorder_id'];
                        if($value['transaction_date'] = "ACTIVE"){
                            $newPurchaseOrder->status = 1;
                        } else {
                            $newPurchaseOrder->status = null;
                        }
                       
                        $newPurchaseOrder->save();
                    }

                    if($purchaseInvoice != null){
                        $purchaseInvoice->purchaseorder_number = $value['purchaseorder_no'];
                        $purchaseInvoice->vendor_id = $supplier->id;
                        $purchaseInvoice->transaction_date = $convertTransactionDate ;
                        $purchaseInvoice->grand_total = $value['grand_total'];
                        $purchaseInvoice->note = $value['note'];
                        $purchaseInvoice->vendor_reference = $value['ref_no'];
                        $purchaseInvoice->bills = $value['bills'];
                        $purchaseInvoice->purchaseorder_id = $value['purchaseorder_id'];
                        if($value['transaction_date'] = "ACTIVE"){
                            $purchaseInvoice->status = 1;
                        } else {
                            $purchaseInvoice->status = null;
                        }

                        $purchaseInvoice->save();
                    }
                  
                }
            }

            return response()->json([
                'status' => 200,
                'message' => "Success sync purchase order !",
            ]);
        }
        catch(Exception $ex){
            Log::info("Error Code : ". $ex->getCode());
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function updateDetailPurchaseOrderSync($userData){
        try{

            $arrPurchaseOrderId = [];
            $purchaseOrder = $this->purchaseOrder::all();

            foreach ($purchaseOrder as $key => $value) {
               array_push($arrPurchaseOrderId, [
                    "purchaseorder_id" => $value['purchaseorder_id']
               ]);
            }

            foreach ($arrPurchaseOrderId as $k => $val) {
                // get purchase order detail api
                $responses = $this->endPointDetailPurchaseOrder($userData, $val);
                $purchaseOrder = PurchaseOrder::where("purchaseorder_id", $val['purchaseorder_id'])->first();

                if($responses->status() == 200){
                    $data = $responses->json()['items'];
                    foreach ($data as $key => $value) {
                        // get detail purchase order
                        $purchaseOrderDetail = PurchaseOrderDetail::where("purchase_id",  $purchaseOrder->id)->where("sku_code", $value['item_code'])->first();
                        if($purchaseOrderDetail == null){
                            Log::info('Create Purchase Order Detail with SKU Code - ' .  $value['item_code']);
                            $newDetailPurchaseOrder = new PurchaseOrderDetail();
                            $newDetailPurchaseOrder->purchase_id = $purchaseOrder->id;
                                    
                            $product = Product::where("sku", $value['item_code'])->first();
                            if($product != null){
                                $newDetailPurchaseOrder->sku_id = $product->id;
                                $newDetailPurchaseOrder->sku_code = $product->sku;
                            }
                            $newDetailPurchaseOrder->description = $value['description'];
                            $newDetailPurchaseOrder->qty = $value['qty_in_base'];
                            $newDetailPurchaseOrder->price = $value['price'];
                            $newDetailPurchaseOrder->discount = $value['disc'];
                            $newDetailPurchaseOrder->total = $value['amount'];
                
                            $newDetailPurchaseOrder->save();
                        } else {
                            Log::info('Update Purchase Order Detail with SKU Code - ' .  $value['item_code']);
                            $purchaseOrderDetail->purchase_id = $purchaseOrder->id;
                                    
                            $product = Product::where("sku", $value['item_code'])->first();
                            if($product != null){
                                $purchaseOrderDetail->sku_id = $product->id;
                                $purchaseOrderDetail->sku_code = $product->sku;
                            }
                            $purchaseOrderDetail->description = $value['description'];
                            $purchaseOrderDetail->qty = $value['qty_in_base'];
                            $purchaseOrderDetail->price = $value['price'];
                            $purchaseOrderDetail->discount = $value['disc'];
                            $purchaseOrderDetail->total = $value['amount'];
                
                            $purchaseOrderDetail->save();
                        }
                    }
                }

            }

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            Log::info("Error Code : ". $ex->getCode());
            if($ex->getCode() == 0){
                $responses = $this->endPointDetailPurchaseOrder($userData, $val);
                Log::info("Retry on process ... ");
            }
            return false;
        }
    }

    public function endPointDetailPurchaseOrder($userData, $val){
        $responses = Http::timeout(10)->retry(3, 1000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/purchase/orders/'. $val['purchaseorder_id']);
        return $responses;

    }

    public function updateTokenApi($userData){
        try{

            $users =  User::find($userData['id'])->first();

            // get new token here
            $loginUser =  Http::post(env('JUBELIO_API') . '/login', [
                'email' => env('JUBELIO_EMAIL'),
                'password' => env('JUBELIO_PASSWORD')
            ]);
            
            if($loginUser->status() == 200){
                // try auth login
                $userLogin = $loginUser->json();
                // set new token
                $users->api_token = $userLogin['token'];
            } 
            // update token
            $users->save();
            return response()->json([
                'status' => 200,
                'message' => "Success update token ",
                'data' => $users
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }