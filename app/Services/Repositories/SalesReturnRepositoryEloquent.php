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
            $salesReturn =  $this->salesReturn::with('channel')->orderBy('transaction_date', 'DESC');
          
            if($request->invoice_number != null){
                $salesReturn = $salesReturn->where("invoice_number", "like", "%" . $request->invoice_number. "%");
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
}