<?php

namespace App\Services\Repositories;

use App\Models\Warehouse;
use App\Services\Interfaces\WarehouseService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class WarehouseRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.04.05
 * @package namespace App\Services\Repositories;
 */

 class WarehouseRepositoryEloquent implements WarehouseService {

     /**
     * @var Warehouse
     */
    private Warehouse $warehouse;

    public function __construct(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;
    }

    public function getWarehouse(Request $request){
        try{
            $warehouse = $this->warehouse;

            if($request->name != null){
                $warehouse = $warehouse->where("name", "like", "%" . $request->name. "%");
            }

            if($request->address != null ){
                $warehouse = $warehouse->where("address", "like", "%" . $request->email. "%");
            }


            if($warehouse != null){
                $datatables = Datatables::of( $warehouse->get() );
                return $datatables->make( true );
            }

            return false;
         }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }

    public function create(Request $request){
        try{
            $warehouse = $this->warehouse;
            $warehouse->fill($request->all());

            if($request->id != null){
                $warehouse = $warehouse::find($request->id);
            }

            $warehouse->name = $request->name;
            $warehouse->address = $request->address;
            $warehouse->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $warehouse
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }

    }

    public function delete(Request $request){
        try{
            $warehouse = $this->warehouse::where("id", $request->id)->first();
            if($warehouse == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $warehouse->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete warehouse.',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $warehouse = $this->warehouse::where("id", $request->id)->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $warehouse
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }