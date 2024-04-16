<?php

namespace App\Services\Repositories;

use App\Models\ItemStock;
use App\Services\Interfaces\ItemStockService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;

use Excel;
use App\Imports\ImportItemStock;

/**
 * Class ItemSctockRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.04.15
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class ItemStockRepositoryEloquent implements ItemStockService{
     /**
     * @var ItemStock
     */
    private ItemStock $itemStock;

    public function __construct(ItemStock $itemStock)
    {
        $this->itemStock = $itemStock;
    }

    public function getItemStock(Request $request){
        try{

            $itemStock = ItemStock::with('product', 'product.category', 'product.unit')->orderBy('id', 'ASC');

            if( ($request->limit != null) && $request->page != null){
                $offset = ($request->page - 1) * $request->limit;

                $itemStock->offset($offset)->limit($request->limit);
            }

            if($request->sku_code != null ){
                $itemStock = $itemStock->whereHas("product", function($q) use ($request){
                    $q->where("sku", "like", "%" . $request->sku_code. "%");
                });
            }

            if($request->article != null ){
                $itemStock = $itemStock->whereHas("product", function($q) use ($request){
                    $q->where("article", "like", "%" . $request->article. "%");
                });
            }

            if($request->start_date != null){
                $itemStock = $itemStock->where("check_in_date", ">=", $request->start_date);
            }

            
            if($request->end_date != null){
                $itemStock = $itemStock->where("check_in_date", "<=", $request->end_date);
            }

            if($request->filter_category != null){
                $itemStock = $itemStock->where("category_id", $request->filter_category);
            }

            $itemStock = $itemStock->get();

            $datatables = Datatables::of($itemStock);
            return $datatables->make( true );

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            $itemStock = $this->itemStock;
            $itemStock->fill($request->all());

            if($request->id != null){
                $itemStock = $itemStock::find($request->id);
            }

            $itemStock->category_id = $request->category_id;
            $itemStock->sku_id = $request->sku_id;
            $itemStock->qty = $request->qty;
            $itemStock->check_in_date = date('Y-m-d');
            $itemStock->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $itemStock
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $itemStock = $this->itemStock::where("id", $request->id)->first();
            if($itemStock == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $itemStock->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete item stock.',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $itemStock = $this->itemStock::where("id", $request->id)->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $itemStock
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function importItemStock(Request $request){
        try{
            
            $itemStock = $this->itemStock;

            if ($request->hasFile('file_import_item_stock')) {
                //GET FILE
                $file = $request->file('file_import_item_stock'); 
                //IMPORT FILE 
                $import = Excel::import(new ImportItemStock, $file);
                if($import){
                    return response()->json([
                        'status' => 200,
                        'message' => true,
                        'data' => $itemStock
                    ]); 
                }
            }  

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }