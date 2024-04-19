<?php

namespace App\Services\Repositories;

use App\Models\SalesInvoice;
use App\Models\SalesInvoiceDetail;
use App\Models\Product;
use App\Models\ItemUnit;
use App\Services\Interfaces\SalesInvoiceService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class SalesInvoiceRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.04.16
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class SalesInvoiceRepositoryEloquent implements SalesInvoiceService{

    /**
    * @var SalesInvoice
    */

    private SalesInvoice $salesInvoice;

    public function __construct(SalesInvoice $salesInvoice)
    {
        $this->salesInvoice = $salesInvoice;
    }

    public function getSalesInvoice(Request $request){
        try{
            
            $salesInvoice = $this->salesInvoice::with('customer')->orderBy('date', 'ASC');
          
            if($request->invoice_number != null){
                $salesInvoice  = $salesInvoice->where("invoice_number", "like", "%" . $request->invoice_number. "%");
            }

            $salesInvoice = $salesInvoice->get();

            $datatables = Datatables::of($salesInvoice);
            return $datatables->make( true );
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{

            $salesInvoice = $this->salesInvoice;
            $salesInvoice->fill($request->all());

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
                }

                if( $value['tax_code'] != null){
                    $taxCode = $value['tax_code'];
                } else {
                    $taxCode = null;
                }

                if( $value['order_number'] != null){
                    $orderNumber =  $value['order_number'];
                } else {
                    $orderNumber = null;
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
                    "order_number" => $orderNumber,
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
                $lastId = DB::table('sales_invoices')->latest()->value('id');
            
                if($lastId == null){
                    $lastId = 0;
                } 
                $lastId = $lastId + 1;
                // concate INV number
                $invNumber = $prefix . '.' . $date . '.' . '00'. $lastId;
            }

            $salesInvoice->invoice_number =  $invNumber;
            $salesInvoice->batch_number =  $request->batch_number;
            $salesInvoice->type =  $request->type;
            $salesInvoice->customer_id =  $request->customer_id;
            $salesInvoice->customer_reference =  $request->customer_reference;
            $salesInvoice->customer_phone =  $request->customer_phone;
            $salesInvoice->date =  $request->date;
            $salesInvoice->due_date =  $request->due_date;
            $salesInvoice->day =  $request->day;
            $salesInvoice->category_invoice_id =  $request->category_invoice_id;
            $salesInvoice->warehouse_id =  $request->warehouse_id;
            $salesInvoice->sales_person =  $request->sales_person;
            $salesInvoice->journal_memo =  $request->journal_memo;
            $salesInvoice->note =  $request->note;
            $salesInvoice->additional_char =  $request->additional_char;
            $salesInvoice->down_pmt =  $request->down_pmt;
            $salesInvoice->tax =  $request->tax;
            $salesInvoice->pph_percent =  $request->pph_percent;
            $salesInvoice->subtotal =  $request->subtotal;
            $salesInvoice->discount_invoice =  $request->discount_invoice;
            $salesInvoice->grand_total =  $request->grand_total;
            $salesInvoice->balance_due =  $request->balance_due;

            // store to database invoices
            $salesInvoice->save();

            // insert bulk detail invoice
            for ($i=0 ; $i < count($arrInvoice) ; $i++ ) { 
                $invoiceDetail = new SalesInvoiceDetail();

                $invoiceDetail->invoice_id = $salesInvoice->id;
                $invoiceDetail->sku_id = $arrInvoice[$i]['sku_id'];
                $invoiceDetail->sku_code = $arrInvoice[$i]['sku_code'];
                $invoiceDetail->description = $arrInvoice[$i]['description'];
                $invoiceDetail->qty = $arrInvoice[$i]['qty'];
                $invoiceDetail->unit_id = $arrInvoice[$i]['unit_id'];
                $invoiceDetail->price = $arrInvoice[$i]['price'];
                $invoiceDetail->discount = $arrInvoice[$i]['discount'];
                $invoiceDetail->total = $arrInvoice[$i]['total'];
                $invoiceDetail->tax_code = $arrInvoice[$i]['tax_code'];
                $invoiceDetail->order_number = $arrInvoice[$i]['order_number'];

                $invoiceDetail->save();
            }
          
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $salesInvoice
            ]); 

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{

            $salesInvoice = $this->salesInvoice::where("id", $request->id)->first();
            $salesInvoiceDetail = SalesInvoiceDetail::where("invoice_id",  $salesInvoice->id);

            if($salesInvoice == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $salesInvoiceDetail->delete();
            $salesInvoice->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete sales invoice.',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        return true;
    }

    public function detailInvoiceItem(Request $request){
        try{
            $salesInvoiceDetail = SalesInvoiceDetail::with("unit")->where("invoice_id", $request->invoice_id)->get();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $salesInvoiceDetail
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function deleteDetailInvoice(Request $request){
        try{
  
            $salesInvoiceDetail = SalesInvoiceDetail::where("id", $request->id)->first();

            if($salesInvoiceDetail == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $salesInvoiceDetail->delete();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $salesInvoiceDetail
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}