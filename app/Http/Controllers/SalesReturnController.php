<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Closure;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Models\SalesReturn;
use App\Models\SalesReturnDetail;
use App\Services\Repositories\SalesReturnRepositoryEloquent;
use App\Jobs\SyncTransactionInvoice;


class SalesReturnController extends Controller
{
     /**
     * @var SalesReturn
    */
    private SalesReturnRepositoryEloquent $service;

    public function __construct(SalesReturnRepositoryEloquent $service) 
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return view("sales_return.index");
    }


    public function getAllSalesReturn(Request $request){
        try{
            $salesReturn = $this->service->getAllSalesReturn($request);
            if($salesReturn != null){
                return $salesReturn;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
