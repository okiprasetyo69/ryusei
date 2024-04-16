<?php

namespace App\Services\Repositories;

use App\Models\SalesInvoice;
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
            
            $salesInvoice = $this->salesInvoice::orderBy('date', 'ASC');
          
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

            // convert to array from json params
            $invoices = json_decode($request->invoices, true);

            $invNumber = "";
            if($request->invoice_number != null){
                $invNumber = $request->invoice_number;
            } else {
                // genereate invoice number
                $prefix = 'INV';
                $date = now()->format('ym');
                $lastId = DB::table('sales_invoices')->latest()->value('id');
            
                if($lastId == null){
                    $lastId = 1;
                } 
                $lastId = $lastId + 1;

                // concate INV number
                $invNumber = $prefix . '.' . $date . '.' . '00'. $lastId;
            }
 
            
          
            //  dd($invNumber);
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
        return true;
    }

    public function detail(Request $request){
        return true;
    }

    
}