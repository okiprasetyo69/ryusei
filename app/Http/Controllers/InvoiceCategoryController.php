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

use App\Models\InvoiceCategory;
use App\Services\Repositories\InvoiceCategoryRepositoryEloquent;

class InvoiceCategoryController extends Controller
{
    /**
     * @var InvoiceCategory
    */
    private InvoiceCategoryRepositoryEloquent $service;

    public function __construct(InvoiceCategoryRepositoryEloquent $service) 
    {
        $this->service = $service;
    }
  
    public function getAllInvoiceCategory(Request $request){
        try{
            $invoiceCategory = $this->service->getInvoiceCategory($request);
            if($invoiceCategory != null){
                return $invoiceCategory;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
