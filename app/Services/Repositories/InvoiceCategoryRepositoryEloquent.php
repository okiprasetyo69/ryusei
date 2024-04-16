<?php

namespace App\Services\Repositories;

use App\Models\InvoiceCategory;
use App\Services\Interfaces\InvoiceCategoryService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * Class InvoiceCategoryRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.04.16
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class InvoiceCategoryRepositoryEloquent implements InvoiceCategoryService {

    /**
     * @var InvoiceCategory
     */
    private InvoiceCategory $invoiceCategory;

    public function __construct(InvoiceCategory $invoiceCategory)
    {
        $this->invoiceCategory = $invoiceCategory;
    }

    public function getInvoiceCategory(Request $request){
        try{
            
            $invoiceCategory = $this->invoiceCategory::orderBy('name', 'ASC');
          
            if($request->name != null){
                $invoiceCategory  = $invoiceCategory->where("name", "like", "%" . $request->name. "%");
            }

            if($request->id != null){
                $invoiceCategory  = $invoiceCategory->where("id", $request->id);
            }

            $invoiceCategory = $invoiceCategory->get();
           
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $invoiceCategory
            ]); 
          
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }