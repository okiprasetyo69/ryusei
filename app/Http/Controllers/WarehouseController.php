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

use App\Models\Warehouse;
use App\Services\Interfaces\WarehouseService;

class WarehouseController extends Controller
{
     /**
     * @var Warehouse
    */
    
    private WarehouseService $service;

    public function __construct(WarehouseService $service) 
    {
        $this->service = $service;
    }


    // WEB
    public function warehousePage(Request $request){
        return view("warehouse.index");
    }

    // API Response
    public function getWarehouse(Request $request){
        try{
            $warehouse = $this->service->getWarehouse($request);
            if($warehouse != null){
                return $warehouse;
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
                'name' => 'required',
                'address' => 'required',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $warehouse = $this->service->create($request);

        if($warehouse) {
            return $warehouse;
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

        $warehouse = $this->service->delete($request);
        if($warehouse) {
            return $warehouse;
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

        $warehouse = $this->service->detail($request);
        if($warehouse) {
            return $warehouse;
        }
    }
}
