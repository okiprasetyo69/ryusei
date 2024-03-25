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

use App\Services\Interfaces\ImportProductService;


class ImportProductController extends Controller
{
    private ImportProductService $service;

    public function __construct(ImportProductService $service) 
    {
        $this->service = $service;
    }

    public function importProduct(Request $request){

       try{
            $validator = Validator::make(
                $request->all(), [
                    'file_import_product' => 'required|mimes:xls,xlsx'
                ]
            );

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 422
                ]);
            }

            $importProduct = $this->service->importProduct($request);

            if($importProduct) {
                return $importProduct;
            }
           
       }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
       }
    }
}
