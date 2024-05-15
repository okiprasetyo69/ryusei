<?php

namespace App\Services\Repositories;

use App\Models\DataWarehouseInvoice;
use App\Models\DataWarehouseDetailInvoice;
use App\Models\Product;
use App\Services\Interfaces\DataWarehouseInvoiceService;
use App\Models\SalesChannel;

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
 * Class DataWarehouseInvoiceRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.05.13
 * 
 *
 * @package namespace App\Services\Repositories;
*/

class DataWarehouseInvoiceRepositoryEloquent implements DataWarehouseInvoiceService {

    /**
     * @var DataWarehouseInvoice
     */
    private DataWarehouseInvoice $dataWarehouseInvoice;

    public function __construct(DataWarehouseInvoice $dataWarehouseInvoice)
    {
        $this->dataWarehouseInvoice = $dataWarehouseInvoice;
    }

    public function getDataWareHouseInvoice(Request $request){
        try{
            
            $dataWarehouseInvoice =  $this->dataWarehouseInvoice::with('customer')->orderBy('transaction_date', 'DESC');
          
            if($request->invoice_number != null){
                $dataWarehouseInvoice = $dataWarehouseInvoice->where("invoice_number", "like", "%" . $request->invoice_number. "%");
            }

            if($request->start_date != null){
                $dataWarehouseInvoice = $dataWarehouseInvoice->where("transaction_date", ">=", $request->start_date);
            }

            if($request->end_date != null){
                $dataWarehouseInvoice = $dataWarehouseInvoice->where("transaction_date", "<=", $request->end_date);
            }

            $dataWarehouseInvoice = $dataWarehouseInvoice->get();

            $datatables = Datatables::of($dataWarehouseInvoice);
            return $datatables->make( true );
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detailInvoice(Request $request){

        try{
            $dataWarehouseInvoiceDetail = DataWarehouseDetailInvoice::orderBy("id", "ASC");

            if($request->invoice_id != null){
                $dataWarehouseInvoiceDetail = $dataWarehouseInvoiceDetail->where("invoice_id", $request->invoice_id);
            }

            $dataWarehouseInvoiceDetail = $dataWarehouseInvoiceDetail->get();
            $datatables = Datatables::of($dataWarehouseInvoiceDetail);
            return $datatables->make( true );

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getDataWareHouseInvoiceFromJubelio($userData, $transactionDateFrom, $transactionDateTo){
        try{

            // String date ISO UTC
            $transactionDateFrom = $transactionDateFrom."T17%3A00%3A00.000Z";
            $transactionDateTo = $transactionDateTo."T16%3A59%3A00.000Z&q=";
            $firstPage = 1;
            $pageSize = 4000;
            
            $responses = $this->endPointSalesInvoiceTransaction($userData, $firstPage,  $pageSize, $transactionDateFrom, $transactionDateTo);
            
            $today = date('Y-m-d');

            if($responses->status() == 200){
                $totalData = $responses->json()['totalCount'];
                $totalPage = ceil($totalData /  $pageSize);
                // Loop every page data
                for($i = 0; $i <= $totalPage; $i++) { 
                    Log::info("Loop Response page: ". $firstPage);

                    $respons = $this->endPointSalesInvoiceTransaction($userData, $firstPage,  $pageSize, $transactionDateFrom, $transactionDateTo);
                    $firstPage = $firstPage + 1;
                    if($respons->status() == 200){
                        $data = $respons->json()['data'];
                        foreach ($data as $key => $value) {
                            $dataWarehouseInvoice = DataWarehouseInvoice::where("invoice_number", $value['doc_number'])->first();
                            $customer = SalesChannel::where("name" , $value['customer_name'])->first();
                            $type = 0;
    
                            if($dataWarehouseInvoice == null){
                                Log::info('Insert Invoice Trx with Doc ID : ' .$value['doc_id'] . ' and Inv Number : '.$value['doc_number']);
                                $newDataWarehouseInvoice = new DataWarehouseInvoice();
                               
                                if( $value['doc_type'] == "invoice"){
                                    $type = 1;
                                }
                                $newDataWarehouseInvoice->doc_id = $value['doc_id'];
                                $newDataWarehouseInvoice->invoice_number = $value['doc_number'];
                                if($customer != null){
                                    $newDataWarehouseInvoice->customer_id = $customer->id;
                                    $newDataWarehouseInvoice->customer_name = $customer->name;
                                }
                                $newDataWarehouseInvoice->customer_reference = $value['ref_no'];
                                $newDataWarehouseInvoice->transaction_date = date_create($value['transaction_date'])->format('Y-m-d');
                                $newDataWarehouseInvoice->due_date = date_create($value['due_date'])->format('Y-m-d');
                                $newDataWarehouseInvoice->grand_total = $value['grand_total'];
                                $newDataWarehouseInvoice->type = $type;
                                $newDataWarehouseInvoice->due = $value['due'];
                                $newDataWarehouseInvoice->sync_date =  $today;
    
                                $newDataWarehouseInvoice->save();
                            }
    
                            if($dataWarehouseInvoice != null){
                                Log::info('Update Invoice Trx with Doc ID : ' .$value['doc_id'] . ' and Inv Number : '.$value['doc_number']);
                                if( $value['doc_type'] == "invoice"){
                                    $type = 1;
                                }
                                $dataWarehouseInvoice->doc_id = $value['doc_id'];
                                $dataWarehouseInvoice->invoice_number = $value['doc_number'];
                                if($customer != null){
                                    $dataWarehouseInvoice->customer_id = $customer->id;
                                    $dataWarehouseInvoice->customer_name = $customer->name;
                                }
                                $dataWarehouseInvoice->customer_reference = $value['ref_no'];
                                $dataWarehouseInvoice->transaction_date = date_create($value['transaction_date'])->format('Y-m-d');
                                $dataWarehouseInvoice->due_date = date_create($value['due_date'])->format('Y-m-d');
                                $dataWarehouseInvoice->grand_total = $value['grand_total'];
                                $dataWarehouseInvoice->type = $type;
                                $dataWarehouseInvoice->due = $value['due'];
                                // $dataWarehouseInvoice->sync_date =  $today;
                                $dataWarehouseInvoice->save();
                            }
                        }
                    }
                }
               
            }

            if($responses->status() == 401){
                $relogin =  $this->updateTokenApi($userData);
            }

            return response()->json([
                'status' => 200,
                'message' => "Success sync data faktur !",
            ]);  
           
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            Log::info("Error Code : ". $ex->getCode());
            if($ex->getCode() == 0  || $ex->getCode() == 404 ){
                $responses = $this->endPointSalesInvoiceTransaction($userData,  $firstPage,  $pageSize, $transactionDateFrom, $transactionDateTo);
                Log::info("Retry on process ... ");
            }
            return false;
        }
    }

    public function getDataWarehouseDetailInvoiceFromJUbelio($userData, $transactionDateFrom, $transactionDateTo){
        try{

            $arrDocId = [];
            $dwhInvoices = DataWarehouseInvoice::where("transaction_date" , ">=",  $transactionDateFrom)
                        ->where("transaction_date" , "<=",  $transactionDateTo)->get();

            $today = date('Y-m-d');
            foreach ($dwhInvoices as $key => $value) {
                array_push($arrDocId, [
                    'id' => $value['id'],
                    'doc_id' => $value['doc_id']
                ]);
            }

            foreach ($arrDocId as $k => $val) {

                Log::info('Get detail transaction invoice detail with Doc ID : ' . $val['doc_id']);
                $responses = $this->endPointDetailSalesInvoceTransaction($userData,  $val);
                $dwhInvoice = DataWarehouseInvoice::where("doc_id", $val['doc_id'])->first();

                if($responses->status() == 200){
                    $data = $responses->json()['items'];
                    foreach ($data as $key => $value){
                        $detailInvoice = DataWarehouseDetailInvoice::where("invoice_id",  $dwhInvoice->id)->where("sku_code", $value['item_code'])->first();
                        $product = Product::where("sku", $value['item_code'])->first();
                        if($detailInvoice == null){
                            Log::info('Create DWH Invoice Detail with SKU Code - ' .  $value['item_code']);
                            $newDetailInvoice = new DataWarehouseDetailInvoice();
                            $newDetailInvoice->invoice_id =  $dwhInvoice->id;
                            if($product != null){
                                $newDetailInvoice->sku_id = $product->id;
                                $newDetailInvoice->sku_code = $product->sku;
                            }
                            $newDetailInvoice->name = $value['item_name'];
                            $newDetailInvoice->description = $value['description'];
                            $newDetailInvoice->qty = $value['qty_in_base'];
                            $newDetailInvoice->price = $value['price'];
                            $newDetailInvoice->discount = $value['disc'];
                            $newDetailInvoice->disc_amount = $value['disc_amount'];
                            $newDetailInvoice->unit = $value['unit'];
                            $newDetailInvoice->amount = $value['amount']; // total
                            $newDetailInvoice->tax_amount = $value['tax_amount'];
                            $newDetailInvoice->sell_price = $value['sell_price'];
                            $newDetailInvoice->original_price = $value['original_price'];
                            $newDetailInvoice->sync_date =  $today;

                            $newDetailInvoice->save();
                        }

                        if($detailInvoice != null){
                            Log::info('Update DWH Invoice Detail with SKU Code - ' .  $value['item_code']);
                            $detailInvoice->invoice_id =  $dwhInvoice->id;
                            if($product != null){
                                $detailInvoice->sku_id = $product->id;
                                $detailInvoice->sku_code = $product->sku;
                            }
                            $detailInvoice->description = $value['description'];
                            $detailInvoice->name = $value['item_name'];
                            $detailInvoice->qty = $value['qty_in_base'];
                            $detailInvoice->price = $value['price'];
                            $detailInvoice->discount = $value['disc'];
                            $detailInvoice->disc_amount = $value['disc_amount'];
                            $detailInvoice->unit = $value['unit'];
                            $detailInvoice->amount = $value['amount']; // total
                            $detailInvoice->tax_amount = $value['tax_amount'];
                            $detailInvoice->sell_price = $value['sell_price'];
                            $detailInvoice->original_price = $value['original_price'];
                            $detailInvoice->sync_date =  $today;

                            $detailInvoice->save();
                        }
                    }
                }
            }   

            return response()->json([
                'status' => 200,
                'message' => "Success sync detail invoice transaction !",
            ]);
           
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            Log::info("Error Code : ". $ex->getCode());
            if($ex->getCode() == 0  || $ex->getCode() == 404 ){
                Log::info("Retry on process ... ");
                $responses = $this->endPointDetailSalesInvoceTransaction($userData,  $val);
            }
            return false;
        }
    }

    public function getTotalInvoiceTrxDataWareHouse($request){
        try{
            $totalInvoice = DB::table("data_ware_house_invoices")->select(DB::raw("COUNT(*) as total_invoice"))->first();
            return response()->json([
                'status' => 200,
                'message' => "Success get total invoice !",
                'data' => $totalInvoice 
            ]); 
           
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function endPointSalesInvoiceTransaction($userData, $firstPage, $pageSize, $transactionDateFrom, $transactionDateTo){
        $responses = Http::timeout(10)->retry(3, 1000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/sales/invoices/?page='.$firstPage.'&pageSize='.$pageSize.'&transactionDateFrom='.$transactionDateFrom.'&transactionDateTo='.$transactionDateTo);
        return $responses;

    }

    public function endPointDetailSalesInvoceTransaction($userData , $val){
        $responses = Http::timeout(10)->retry(3, 1000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/sales/invoices/'.$val['doc_id']);
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
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}