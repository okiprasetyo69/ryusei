<?php

namespace App\Services\Repositories;

use App\Models\PurchaseInvoice;
use App\Models\PurchasingInvoiceDetail;
use App\Models\Product;
use App\Models\ItemUnit;
use App\Models\ItemStock;
use App\Services\Constants\SalesInvoiceConstantInterface;
use App\Services\Constants\WarehouseConstantInterface;
use App\Services\Interfaces\PurchasingInvoiceService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

/**
 * Class PurchasingInvoiceRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.04.16
 * 
 *
 * @package namespace App\Services\Repositories;
 */


 class PurchasingInvoiceRepositoryEloquent implements PurchasingInvoiceService{

     /**
    * @var PurchaseInvoice
    */

    private PurchaseInvoice $purchaseInvoice;
    private ItemStock $itemStock;
    private Product $product;

    public function __construct(PurchaseInvoice $purchaseInvoice, ItemStock $itemStock, Product $product)
    {
        $this->purchaseInvoice = $purchaseInvoice;
        $this->itemStock = $itemStock;
        $this->product = $product;
    }

    public function getPurchasingInvoice(Request $request){
        try{
            
            $purchaseInvoice = $this->purchaseInvoice::with('vendor')->orderBy('date', 'ASC');
          
            if($request->invoice_number != null){
                $purchaseInvoice  = $purchaseInvoice->where("invoice_number", "like", "%" . $request->invoice_number. "%");
            }

            if($request->start_date != null){
                $purchaseInvoice  = $purchaseInvoice->where("date", ">=",$request->start_date);
            }

            if($request->end_date != null){
                $purchaseInvoice  = $purchaseInvoice->where("date", "<=", $request->end_date);
            }

            if($request->open_state != null){
                $purchaseInvoice  = $purchaseInvoice->where("state", $request->open_state);
            }

            if($request->close_state != null){
                $purchaseInvoice  = $purchaseInvoice->where("state", $request->close_state);
            }

            if($request->draft_state != null){
                $purchaseInvoice  = $purchaseInvoice->where("state", $request->draft_state);
            }

            if($request->void_state != null){
                $purchaseInvoice  = $purchaseInvoice->where("state", $request->void_state);
            }

            $purchaseInvoice = $purchaseInvoice->get();

            $datatables = Datatables::of($purchaseInvoice);
            return $datatables->make( true );
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{

            $purchaseInvoice = $this->purchaseInvoice;
            $purchaseInvoice->fill($request->all());

            $arrInvoice = [];
            // convert to array from json params
            $invoices = json_decode($request->invoices, true);

            $skuId = null;
            $description = "";
            $unitId = null;
            $discount = null;
            $taxCode = null;
            $orderNumber = "";
            foreach ($invoices as $key => $value) {
               
                if($value["sku_id"] == null ){
                    $product = Product::where("sku", $value['sku_code'])->first();
                    $skuId =  $product->id;
                } else {
                    $skuId = $value["sku_id"];
                }

                if($value['description'] == null){
                    $product = Product::where("sku", $value['sku_code'])->first();
                    $description =  $product->article;
                } else{
                    $description = $value['description'];
                }

                if($value['unit_id'] == null){
                    if($value['unit_name'] != null){
                        $itemUnit = ItemUnit::where("name", $value['unit_name'])->first();
                        $unitId = $itemUnit->id;
                    } else {
                        $unitId = null;
                    }
                }else {
                    $unitId = $value['unit_id'];
                }

                if($value['discount'] != null){
                    $discount = $value['discount'];
                } else {
                    $discount = null;
                }

                if( $value['tax_code'] != null){
                    $taxCode = $value['tax_code'];
                } else {
                    $taxCode = null;
                }

               array_push($arrInvoice, [
                    "sku_id" => $skuId,
                    "sku_code" => $value['sku_code'],
                    "description" =>  $description,
                    "qty" =>  $value['qty'],
                    "unit_name" => $value['unit_name'],
                    "unit_id" =>  $unitId ,
                    "price" => $value['price'],
                    "discount" => $discount,
                    "total" => $value['total'],
                    "tax_code" =>  $taxCode ,
                ]);
            }
            
            // create invoice number
            $invNumber = "";
            if($request->invoice_number != null){
                $invNumber = $request->invoice_number;
            } else {
                // genereate invoice number
                $prefix = 'INV';
                $date = now()->format('ym');
                $today = Carbon::today();
                $month = $today->format('m');
                $year = $today->format('Y');
                $invoice = PurchaseInvoice::whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('id', 'desc')->first();
                $count = 0;

                if($invoice == null){
                    $invNumber =  $prefix . '.' . $date . '.' . $count + 1 ;
                } else {
                    $lastInvoice =  explode(".", $invoice->invoice_number);
                    $lastNumber = $lastInvoice[count($lastInvoice) - 1];
                    $invNumber =  $prefix . '.' . $date . '.' . $lastNumber + 1;
                }
            }

            $purchaseInvoice->invoice_number =  $invNumber;
            $purchaseInvoice->batch_number =  $request->batch_number;
            $purchaseInvoice->type =  $request->type;
            $purchaseInvoice->vendor_id =  $request->vendor_id;
            $purchaseInvoice->vendor_reference =  $request->vendor_reference;
            $purchaseInvoice->vendor_phone =  $request->vendor_phone;
            $purchaseInvoice->date =  $request->date;
            $purchaseInvoice->due_date =  $request->due_date;
            $purchaseInvoice->day =  $request->day;
            $purchaseInvoice->category_invoice_id =  $request->category_invoice_id;

            if($request->warehouse_id == null){
                $purchaseInvoice->warehouse_id =  WarehouseConstantInterface::CENTER_WAREHOUSE;
            } else {
                $purchaseInvoice->warehouse_id =  $request->warehouse_id;
            }

            $purchaseInvoice->journal_memo =  $request->journal_memo;
            $purchaseInvoice->note =  $request->note;
            $purchaseInvoice->additional_char =  $request->additional_char;
            $purchaseInvoice->down_pmt =  $request->down_pmt;
            $purchaseInvoice->tax =  $request->tax;
            $purchaseInvoice->pph_percent =  $request->pph_percent;
            $purchaseInvoice->subtotal =  $request->subtotal;
            $purchaseInvoice->discount_invoice =  $request->discount_invoice;
            $purchaseInvoice->grand_total =  $request->grand_total;
            $purchaseInvoice->balance_due =  $request->balance_due;
            $purchaseInvoice->state =  SalesInvoiceConstantInterface::OPEN;
            $purchaseInvoice->is_deleted = SalesInvoiceConstantInterface::INVOICE_IS_ACKTIVE;

            // store to database invoices
            $purchaseInvoice->save();

             // insert bulk detail invoice
            for ($i=0 ; $i < count($arrInvoice) ; $i++ ) { 
                $invoiceDetail = new PurchasingInvoiceDetail();

                $invoiceDetail->invoice_id = $purchaseInvoice->id;
                $invoiceDetail->sku_id = $arrInvoice[$i]['sku_id'];
                $invoiceDetail->sku_code = $arrInvoice[$i]['sku_code'];
                $invoiceDetail->description = $arrInvoice[$i]['description'];
                $invoiceDetail->qty = $arrInvoice[$i]['qty'];
                $invoiceDetail->unit_id = $arrInvoice[$i]['unit_id'];
                $invoiceDetail->price = $arrInvoice[$i]['price'];
                $invoiceDetail->discount = $arrInvoice[$i]['discount'];
                $invoiceDetail->total = $arrInvoice[$i]['total'];
                $invoiceDetail->tax_code = $arrInvoice[$i]['tax_code'];

                // check exist product data
                $product = Product::where("sku",  $arrInvoice[$i]['sku_code'])->first();
                if($product == null){
                    return response()->json([
                        'status' => 404 ,
                        'message' => 'Data product with '. $arrInvoice[$i]['sku_code'].' not available. Please enter new product ! ',
                    ]);
                }
               
                // check exist item stock & Upsert to stock item here

                $itemStock = ItemStock::where("sku_id",  $product->id)->first();
                if($itemStock != null){
                    // update stock 
                    $currentStock =  $itemStock->qty; 
                    $itemStock->qty =  $arrInvoice[$i]['qty'] +  $currentStock ;

                    $itemStock->save();
                }
                if($itemStock == null) {
                    // insert item
                    $items = new ItemStock();
                    $items->category_id =  $product->category_id;
                    $items->sku_id =  $arrInvoice[$i]['sku_id'];
                    $items->qty =  $arrInvoice[$i]['qty'];
                    $items->check_in_date = date('Y-m-d');

                    if($request->warehouse_id == null){
                        $items->warehouse_id =  WarehouseConstantInterface::CENTER_WAREHOUSE;
                    } else {
                        $items->warehouse_id = $request->warehouse_id;
                    }

                    $items->save();
                }

                $invoiceDetail->save();
               
            }
          
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $purchaseInvoice
            ]); 

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function update(Request $request){
        try{

            DB::beginTransaction();

            $purchaseInvoice = $this->purchaseInvoice;
            $purchaseInvoice->fill($request->all());

            $itemStock =  $this->itemStock;
            $itemStock->fill($request->all());

            $product =  $this->product;
            $product->fill($request->all());

            // Find Invoice
            if($request->id != null){
                $purchaseInvoice = $purchaseInvoice::find($request->id);
            }

            // Find invoice detail then delete
            $invoiceDetail = PurchasingInvoiceDetail::where("invoice_id", $request->id);
            if($invoiceDetail != null){
                $invoiceDetail->delete();
            }

            $arrInvoice = [];
            // convert to array from json params
            $invoices = json_decode($request->invoices, true);

            $skuId = null;
            $description = "";
            $unitId = null;
            $discount = null;
            $taxCode = null;

            foreach ($invoices as $key => $value) {
               
                if($value["sku_id"] == null ){
                    $product = Product::where("sku", $value['sku_code'])->first();
                    $skuId =  $product->id;
                } else {
                    $skuId = $value["sku_id"];
                }

                if($value['description'] == null){
                    $product = Product::where("sku", $value['sku_code'])->first();
                    $description =  $product->article;
                } else{
                    $description = $value['description'];
                }

                if($value['unit_id'] == ""){
                    if($value['unit_name'] != null){
                        $itemUnit = ItemUnit::where("name", $value['unit_name'])->first();
                        $unitId = $itemUnit->id;
                    } else {
                        $unitId = null;
                    }
                }else {
                    $unitId = $value['unit_id'];
                }

                if($value['discount'] != null){
                    $discount = $value['discount'];
                } else {
                    $discount = null;
                }

                if( $value['tax_code'] != null){
                    $taxCode = $value['tax_code'];
                } else {
                    $taxCode = null;
                }

               array_push($arrInvoice, [
                    "sku_id" => $skuId,
                    "sku_code" => $value['sku_code'],
                    "description" =>  $description,
                    "qty" =>  $value['qty'],
                    "unit_name" => $value['unit_name'],
                    "unit_id" =>  $unitId ,
                    "price" => $value['price'],
                    "discount" => $discount,
                    "total" => $value['total'],
                    "tax_code" =>  $taxCode ,
                ]);
            }

            $purchaseInvoice->invoice_number =  $request->invoice_number;
            $purchaseInvoice->batch_number =  $request->batch_number;
            // $purchaseInvoice->type =  $request->type;
            $purchaseInvoice->vendor_id=  $request->vendor_id;
            $purchaseInvoice->vendor_reference =  $request->vendor_reference;
            $purchaseInvoice->vendor_phone =  $request->vendor_phone;
            $purchaseInvoice->date =  $request->date;
            $purchaseInvoice->due_date =  $request->due_date;
            $purchaseInvoice->day =  $request->day;
            $purchaseInvoice->category_invoice_id =  $request->category_invoice_id;

            if($request->warehouse_id == null){
                $purchaseInvoice->warehouse_id =  WarehouseConstantInterface::CENTER_WAREHOUSE;
            } else {
                $purchaseInvoice->warehouse_id =  $request->warehouse_id;
            }
            
            $purchaseInvoice->journal_memo =  $request->journal_memo;
            $purchaseInvoice->note =  $request->note;
            $purchaseInvoice->additional_char =  $request->additional_char;
            $purchaseInvoice->down_pmt =  $request->down_pmt;
            $purchaseInvoice->tax =  $request->tax;
            $purchaseInvoice->pph_percent =  $request->pph_percent;
            $purchaseInvoice->subtotal =  $request->subtotal;
            $purchaseInvoice->discount_invoice =  $request->discount_invoice;
            $purchaseInvoice->grand_total =  $request->grand_total;
            $purchaseInvoice->balance_due =  $request->balance_due;

            // store to database invoices
            $purchaseInvoice->save();

            // insert bulk detail invoice
            for ($i=0 ; $i < count($arrInvoice) ; $i++ ) { 
                $invoiceDetail = new PurchasingInvoiceDetail();

                $invoiceDetail->invoice_id = $purchaseInvoice->id;
                $invoiceDetail->sku_id = $arrInvoice[$i]['sku_id'];
                $invoiceDetail->sku_code = $arrInvoice[$i]['sku_code'];
                // Upsert to stock item here

                $invoiceDetail->description = $arrInvoice[$i]['description'];
                $invoiceDetail->qty = $arrInvoice[$i]['qty'];
                $invoiceDetail->unit_id = $arrInvoice[$i]['unit_id'];
                $invoiceDetail->price = $arrInvoice[$i]['price'];
                $invoiceDetail->discount = $arrInvoice[$i]['discount'];
                $invoiceDetail->total = $arrInvoice[$i]['total'];
                $invoiceDetail->tax_code = $arrInvoice[$i]['tax_code'];

                // check exist product data
                $product = Product::where("sku",  $arrInvoice[$i]['sku_code'])->first();
                if($product == null){
                    return response()->json([
                        'status' => 404 ,
                        'message' => 'Data product with '. $arrInvoice[$i]['sku_code'].' not available. Please enter new product ! ',
                    ]);
                }
                 
                // check exist item stock & Upsert to stock item here
                $itemStock = ItemStock::where("sku_id",  $product->id)->first();
                if($itemStock != null){
                      // update stock 
                      $currentStock =  $itemStock->qty; 
                      $itemStock->qty =  $arrInvoice[$i]['qty'] +  $currentStock ;
  
                      $itemStock->save();
                }

                if($itemStock == null) {
                    // insert item
                    $items = new ItemStock();
                    $items->category_id =  $product->category_id;
                    $items->sku_id =  $arrInvoice[$i]['sku_id'];
                    $items->qty =  $arrInvoice[$i]['qty'];
                    $items->check_in_date = date('Y-m-d');
                    if($request->warehouse_id == null){
                        $items->warehouse_id =  WarehouseConstantInterface::CENTER_WAREHOUSE;
                    } else {
                        $items->warehouse_id = $request->warehouse_id;
                    }
                    
                    $items->save();
                }
  
                $invoiceDetail->save();
            }
            
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $purchaseInvoice
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
    
    public function delete(Request $request){
        try{

            $purchaseInvoice = $this->purchaseInvoice::where("id", $request->id)->first();
            // $salesInvoiceDetail = SalesInvoiceDetail::where("invoice_id",  $salesInvoice->id);
            $prefix = "Void:";
            $invoiceNumber = $purchaseInvoice->invoice_number;
            $voidNumber =  $prefix. $invoiceNumber;
            $purchaseInvoice->invoice_number = $voidNumber;
            $purchaseInvoice->state =  SalesInvoiceConstantInterface::VOID;
            $purchaseInvoice->is_deleted = SalesInvoiceConstantInterface::INVOICE_IS_DELETED;

            if($purchaseInvoice == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            // $salesInvoiceDetail->save();
            $purchaseInvoice->save();
            return response()->json([
                'status' => 200,
                'message' => 'Success deleted purchase invoice.',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
    
    public function detail(Request $request){}

    public function detailInvoiceItem(Request $request){
        try{
            $purchaseInvoiceDetail = PurchasingInvoiceDetail::with("unit")->where("invoice_id", $request->invoice_id)->get();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $purchaseInvoiceDetail
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }