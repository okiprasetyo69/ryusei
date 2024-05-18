<?php

namespace App\Services\Repositories;

use App\Models\SalesReturn;
use App\Models\SalesReturnDetail;
use App\Models\SalesChannel;
use App\Models\Product;
use App\Models\User;
use App\Services\Interfaces\SalesReturnService;

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
 * Class SalesReturnRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.05.17
 * 
 *
 * @package namespace App\Services\Repositories;
*/

class SalesReturnRepositoryEloquent implements SalesReturnService {

    /**
    * @var SalesReturn
    */
    private SalesReturn $salesReturn;

    public function __construct(SalesReturn $salesReturn)
    {
        $this->salesReturn = $salesReturn;
    }

    public function getAllSalesReturn(Request $request){
        try{
            $salesReturn =  $this->salesReturn::with('customer')->orderBy('transaction_date', 'DESC');
          
            if($request->invoice_number != null){
                $salesReturn = $salesReturn->where("invoice_number", "like", "%" . $request->invoice_number. "%");
            }

            if($request->doc_number != null){
                $salesReturn = $salesReturn->where("doc_number", "like", "%" . $request->doc_number. "%");
            }

            if($request->start_date != null){
                $salesReturn = $salesReturn->where("transaction_date", ">=", $request->start_date);
            }

            if($request->end_date != null){
                $salesReturn = $salesReturn->where("transaction_date", "<=", $request->end_date);
            }

            $salesReturn = $salesReturn->get();

            $datatables = Datatables::of($salesReturn);
            return $datatables->make( true );

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detailSalesReturn(Request $request){
        try{
            $detailSalesReturn = SalesReturnDetail::orderBy("id", "ASC");

            if($request->sales_return_id != null){
                $detailSalesReturn = $detailSalesReturn->where("sales_return_id", $request->sales_return_id);
            }

            $detailSalesReturn = $detailSalesReturn->get();
           
            $datatables = Datatables::of($detailSalesReturn);

            return $datatables->make( true );

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getSalesReturnFromJubelio($userData, $transactionDateFrom, $transactionDateTo){
        try{

            // String date ISO UTC
            $transactionDateFrom = $transactionDateFrom."T17%3A00%3A00.000Z";
            $transactionDateTo = $transactionDateTo."T16%3A59%3A00.000Z&q=";
            $firstPage = 1;
            $pageSize = 3000;
            $today = date('Y-m-d');
            $responses = $this->endPointSalesReturnFromJubelio($userData, $firstPage,  $pageSize, $transactionDateFrom, $transactionDateTo);
            
            if($responses->status() == 401){
                $relogin =  $this->updateTokenApi($userData);
            }

            if($responses->status() == 200){
                $totalData = $responses->json()['totalCount'];
                $totalPage = ceil($totalData /  $pageSize) + 10;
                Log::info("Loop Response page : ". $firstPage);
                $respons = $this->endPointSalesReturnFromJubelio($userData, $firstPage,  $pageSize, $transactionDateFrom, $transactionDateTo);
                $firstPage = $firstPage + 1;
                if($respons->status() == 200){
                    $data = $respons->json()['data'];
                    foreach ($data as $key => $value){
                        $salesReturn =  $this->salesReturn::where("doc_id", $value['doc_id'])->where("doc_number", $value['doc_number'])->first();
                        $channel = SalesChannel::where("name" , $value['customer_name'])->first();

                        if($salesReturn == null){
                            Log::info('Insert Sales Return with Doc ID : ' .$value['doc_id'] . ' and Invoice Number : '.$value['ref_no']);
                            $newSalesReturn = new SalesReturn();
                            $newSalesReturn->doc_id = $value['doc_id'];
                            $newSalesReturn->doc_number = $value['doc_number'];
                            if($channel != null){
                                $newSalesReturn->customer_id = $channel->id;
                                $newSalesReturn->customer_name = $channel->name;
                            }
                            $newSalesReturn->invoice_number = $value['ref_no'];
                            $newSalesReturn->transaction_date = date_create($value['transaction_date'])->format('Y-m-d');
                            $newSalesReturn->due_date = date_create($value['due_date'])->format('Y-m-d');
                            $newSalesReturn->grand_total = $value['grand_total'];
                            $newSalesReturn->due = $value['due'];
                            $newSalesReturn->downpayment_amount = $value['downpayment_amount'];
                            $newSalesReturn->doc_type = $value['doc_type'];
                            $newSalesReturn->age = $value['age'];
                            $newSalesReturn->age_due = $value['age_due'];
                            $newSalesReturn->store_name = $value['store_name'];
                            $newSalesReturn->return_type = $value['return_type'];
                            $newSalesReturn->sync_date =  $today;

                            $newSalesReturn->save();
                        }   

                        if($salesReturn != null){
                            if($channel != null){
                                $salesReturn->customer_id = $channel->id;
                                $salesReturn->customer_name = $channel->name;
                            }
                            $salesReturn->invoice_number = $value['ref_no'];
                            $salesReturn->transaction_date = date_create($value['transaction_date'])->format('Y-m-d');
                            $salesReturn->due_date = date_create($value['due_date'])->format('Y-m-d');
                            $salesReturn->grand_total = $value['grand_total'];
                            $salesReturn->due = $value['due'];
                            $salesReturn->downpayment_amount = $value['downpayment_amount'];
                            $salesReturn->doc_type = $value['doc_type'];
                            $salesReturn->age = $value['age'];
                            $salesReturn->age_due = $value['age_due'];
                            $salesReturn->store_name = $value['store_name'];
                            $salesReturn->return_type = $value['return_type'];
                            
                            $salesReturn->save();
                        }
                    }
                }
            }

            return response()->json([
                'status' => 200,
                'message' => "Success sync data sales retur !",
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getDetailSalesReturnFromJubelio($userData, $transactionDateFrom, $transactionDateTo){
        try{
            $arrSalesReturn = [];
            $salesReturn =  $this->salesReturn::where("transaction_date" , ">=",  $transactionDateFrom)
                                ->where("transaction_date" , "<=",  $transactionDateTo)->get();
            $today = date('Y-m-d');

            foreach ($salesReturn as $key => $value) {
                array_push($arrSalesReturn, [
                    'doc_id' => $value['doc_id'],
                ]);
            }

            // foreach ($salesReturn as $key => $value) {
            //     array_push($arrSalesReturn, $value['doc_id']);
            // }

            // $i = 0;
            // while(!empty($arrSalesReturn)){
            //     dd($arrSalesReturn[$i]);
            //     Log::info('Get detail sales return with Doc ID : ' . $arrSalesReturn[$i]);
            //     $salesReturn =  $this->salesReturn::where("doc_id", $arrSalesReturn[$i])->first();
            //     $responses = $this->endPointDetailSalesReturnFromJubelio($userData, $arrSalesReturn[$i]);

            //     if($responses->status() == 200){

            //         if (isset($arrSalesReturn[$i])){
            //             $data = $responses->json()['items'];
            //             if($salesReturn != null){
            //                 $salesReturn->sub_total = $responses->json()['sub_total'];
            //                 $salesReturn->total_disc = $responses->json()['total_disc'];
            //                 $salesReturn->total_tax = $responses->json()['total_tax'];
            //                 $salesReturn->add_disc = $responses->json()['add_disc'];
            //                 $salesReturn->add_fee = $responses->json()['add_fee'];
            //                 $salesReturn->service_fee = $responses->json()['service_fee'];
            //                 $salesReturn->salesorder_no = $responses->json()['salesorder_no'];
                            
            //                 $salesReturn->save();
            //             }
    
            //             foreach ($data as $key => $value) {
            //                 $detailSalesReturn = SalesReturnDetail::where("sales_return_id",  $salesReturn->id)
            //                                     ->where("sku_code", $value['item_code'])->first();
            //                 $product = Product::where("sku", $value['item_code'])->first();
    
            //                 if($detailSalesReturn == null){
            //                     Log::info('Create Sales Order Detail with SKU Code - ' .  $value['item_code']);
            //                     $newDetailSalesReturn = new SalesReturnDetail();
            //                     $newDetailSalesReturn->sales_return_id =  $salesReturn->id;
            //                     if($product != null){
            //                         $newDetailSalesReturn->sku_id = $product->id;
            //                         $newDetailSalesReturn->sku_code = $product->sku;
            //                         $newDetailSalesReturn->name = $product->name;
            //                     } 
            //                     $newDetailSalesReturn->tax_id = $value['tax_id'];
            //                     $newDetailSalesReturn->description = $value['description'];
            //                     $newDetailSalesReturn->price = $value['price'];
            //                     $newDetailSalesReturn->qty = $value['qty'];
            //                     $newDetailSalesReturn->unit = $value['unit'];
            //                     $newDetailSalesReturn->qty_in_base = $value['qty_in_base'];
            //                     $newDetailSalesReturn->amount = $value['amount'];
            //                     $newDetailSalesReturn->cogs = $value['cogs'];
            //                     $newDetailSalesReturn->tax_amount = $value['tax_amount'];
            //                     $newDetailSalesReturn->discount = $value['disc'];
            //                     $newDetailSalesReturn->disc_amount = $value['disc_amount'];
            //                     $newDetailSalesReturn->sell_price = $value['sell_price'];
            //                     $newDetailSalesReturn->original_price = $value['original_price'];
            //                     $newDetailSalesReturn->rate = $value['rate'];
            //                     $newDetailSalesReturn->tax_name = $value['tax_name'];
            //                     $newDetailSalesReturn->available_qty = $value['available_qty'];
    
            //                     $newDetailSalesReturn->sync_date = $today;
    
            //                     $newDetailSalesReturn->save();
            //                 }    
                            
            //                 if($detailSalesReturn != null){
            //                     Log::info('Update Sales Return Detail with SKU Code - ' .  $value['item_code']);
            //                     if($product != null){
            //                         $detailSalesReturn->sku_id = $product->id;
            //                         $detailSalesReturn->sku_code = $product->sku;
            //                         $detailSalesReturn->name = $product->name;
            //                     } 
    
            //                     $detailSalesReturn->tax_id = $value['tax_id'];
            //                     $detailSalesReturn->price = $value['price'];
            //                     $detailSalesReturn->qty = $value['qty'];
            //                     $detailSalesReturn->unit = $value['unit'];
            //                     $detailSalesReturn->qty_in_base = $value['qty_in_base'];
            //                     $detailSalesReturn->amount = $value['amount'];
            //                     $detailSalesReturn->cogs = $value['cogs'];
            //                     $detailSalesReturn->tax_amount = $value['tax_amount'];
            //                     $detailSalesReturn->discount = $value['disc'];
            //                     $detailSalesReturn->disc_amount = $value['disc_amount'];
            //                     $detailSalesReturn->sell_price = $value['sell_price'];
            //                     $detailSalesReturn->original_price = $value['original_price'];
            //                     $detailSalesReturn->rate = $value['rate'];
            //                     $detailSalesReturn->tax_name = $value['tax_name'];
            //                     $detailSalesReturn->available_qty = $value['available_qty'];
    
            //                     $detailSalesReturn->save();
            //                 }
            //             }
            //             // remove array index
            //             unset($arrSalesReturn[$i]);
            //             Log::info('Remove array : ' .  $arrSalesReturn[$i]);
            //             $arrSalesReturn = array_values($arrSalesReturn);
                        
            //         }

            //     }
            // }

            foreach ($arrSalesReturn as $k => $val) {
                Log::info('Get detail sales return with Doc ID : ' . $val['doc_id']);
                $salesReturn =  $this->salesReturn::where("doc_id", $val['doc_id'])->first();
                $responses = $this->endPointDetailSalesReturnFromJubelio($userData,  $val);

                if($salesReturn != null){
                    $salesReturn->sub_total = $responses->json()['sub_total'];
                    $salesReturn->total_disc = $responses->json()['total_disc'];
                    $salesReturn->total_tax = $responses->json()['total_tax'];
                    $salesReturn->add_disc = $responses->json()['add_disc'];
                    $salesReturn->add_fee = $responses->json()['add_fee'];
                    $salesReturn->service_fee = $responses->json()['service_fee'];
                    $salesReturn->salesorder_no = $responses->json()['salesorder_no'];
                   
                    $salesReturn->save();
                }

                if($responses->status() == 200){
                    $data = $responses->json()['items'];
                    foreach ($data as $key => $value) {
                        $detailSalesReturn = SalesReturnDetail::where("sales_return_id",  $salesReturn->id)
                                            ->where("sku_code", $value['item_code'])->first();
                        $product = Product::where("sku", $value['item_code'])->first();

                        if($detailSalesReturn == null){
                            Log::info('Create Sales Order Detail with SKU Code - ' .  $value['item_code']);
                            $newDetailSalesReturn = new SalesReturnDetail();
                            $newDetailSalesReturn->sales_return_id =  $salesReturn->id;
                            if($product != null){
                                $newDetailSalesReturn->sku_id = $product->id;
                                $newDetailSalesReturn->sku_code = $product->sku;
                                $newDetailSalesReturn->name = $product->name;
                            } 
                            $newDetailSalesReturn->tax_id = $value['tax_id'];
                            $newDetailSalesReturn->description = $value['description'];
                            $newDetailSalesReturn->price = $value['price'];
                            $newDetailSalesReturn->qty = $value['qty'];
                            $newDetailSalesReturn->unit = $value['unit'];
                            $newDetailSalesReturn->qty_in_base = $value['qty_in_base'];
                            $newDetailSalesReturn->amount = $value['amount'];
                            $newDetailSalesReturn->cogs = $value['cogs'];
                            $newDetailSalesReturn->tax_amount = $value['tax_amount'];
                            $newDetailSalesReturn->disc = $value['disc'];
                            $newDetailSalesReturn->disc_amount = $value['disc_amount'];
                            $newDetailSalesReturn->sell_price = $value['sell_price'];
                            $newDetailSalesReturn->original_price = $value['original_price'];
                            $newDetailSalesReturn->rate = $value['rate'];
                            $newDetailSalesReturn->tax_name = $value['tax_name'];
                            $newDetailSalesReturn->available_qty = $value['available_qty'];

                            $newDetailSalesReturn->sync_date = $today;

                            $newDetailSalesReturn->save();
                        }    
                        
                        if($detailSalesReturn != null){
                            Log::info('Update Sales Return Detail with SKU Code - ' .  $value['item_code']);
                            if($product != null){
                                $detailSalesReturn->sku_id = $product->id;
                                $detailSalesReturn->sku_code = $product->sku;
                                $detailSalesReturn->name = $product->name;
                            } 

                            $detailSalesReturn->tax_id = $value['tax_id'];
                            $detailSalesReturn->price = $value['price'];
                            $detailSalesReturn->qty = $value['qty'];
                            $detailSalesReturn->unit = $value['unit'];
                            $detailSalesReturn->qty_in_base = $value['qty_in_base'];
                            $detailSalesReturn->amount = $value['amount'];
                            $detailSalesReturn->cogs = $value['cogs'];
                            $detailSalesReturn->tax_amount = $value['tax_amount'];
                            $detailSalesReturn->sell_price = $value['sell_price'];
                            $detailSalesReturn->original_price = $value['original_price'];
                            $detailSalesReturn->rate = $value['rate'];
                            $detailSalesReturn->tax_name = $value['tax_name'];
                            $detailSalesReturn->available_qty = $value['available_qty'];

                            $detailSalesReturn->save();
                        }
                    }
                }
            }
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            Log::info("Error Code : ". $ex->getCode());
            if($ex->getCode() == 0  || $ex->getCode() == 404 ){
                Log::info("Retry on process ... ");
                $responses = $this->endPointDetailSalesReturnFromJubelio($userData,  $val);
            }
            return false;
        }
    }

    public function endPointSalesReturnFromJubelio($userData, $firstPage,  $pageSize, $transactionDateFrom, $transactionDateTo){
        $responses = Http::timeout(10)->retry(3, 3000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/sales/sales-returns/?page='.$firstPage.'&pageSize='.$pageSize.'&transactionDateFrom='.$transactionDateFrom.'&transactionDateTo='.$transactionDateTo);
        return $responses;
    }

    public function endPointDetailSalesReturnFromJubelio($userData , $val){
        $responses = Http::timeout(10)->retry(3, 1000)->withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/sales/sales-returns/'.$val);
        return $responses;
    }

    public function getTotalSalesReturn(Request $request){
        try{
            $totalSalesReturn = DB::table("sales_returns")->select(DB::raw("COUNT(*) as total_return"))->first();
            return response()->json([
                'status' => 200,
                'message' => "Success get total return !",
                'data' => $totalSalesReturn 
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