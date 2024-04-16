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

use App\Models\ItemStock;
use App\Services\Interfaces\ItemStockService;

class ItemStockController extends Controller
{
    /**
     * @var ItemStock
    */
    
    private ItemStockService $service;

    public function __construct(ItemStockService $service) 
    {
        $this->service = $service;
    }

    // WEB
    public function index(Request $request){
        return view("warehouse.incoming_items");
    }

    public function downloadFormatImportStockItems(){
        $path = public_path('/import/Format_Import_Stock_Items.xlsx');
        return response()->download($path);
    }

    // API
    public function getItemStock(Request $request){
        try{
            $itemStock = $this->service->getItemStock($request);
            if($itemStock != null){
                return $itemStock;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'category_id' => 'required',
                'sku_id' => 'required',
                'qty' => 'required',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $itemStock = $this->service->create($request);

        if($itemStock) {
            return $itemStock;
        }
    }

    public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors(),
                'status' => 422
            ]);
        }

        $itemStock = $this->service->delete($request);
        if($itemStock) {
            return $itemStock;
        }    
    }

    public function detail(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors(),
                'status' => 422
            ]);
        }

        $itemStock = $this->service->detail($request);
        return $itemStock;
    }

    public function importItemStock(Request $request)
    {
        try{
             $validator = Validator::make(
                 $request->all(), [
                     'file_import_item_stock' => 'required|mimes:xls,xlsx'
                 ]
             );
 
             if($validator->fails()){
                 return response()->json([
                     'data' => null,
                     'message' => $validator->errors()->first(),
                     'status' => 422
                 ]);
             }
 
             $importItemStock = $this->service->importItemStock($request);
 
             if($importItemStock) {
                 return $importItemStock;
             }
            
        }catch(Exception $ex){
             Log::error($ex->getMessage());
             return false;
        }
    }
}
