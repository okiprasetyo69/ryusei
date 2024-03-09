<?php

namespace App\Services\Repositories;

use App\Models\Product;
use App\Services\Interfaces\ProductService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class ProductRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.09
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class ProductRepositoryEloquent implements ProductService{

       /**
     * @var Product
     */
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(Request $request){
        try{
            
            $product = $this->product::with('category');
          
            if($request->name != null){
                $product->where("name", "like", "%" . $request->name. "%");
            }

            $product = $product->get();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $product
            ]); 
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        return true;
    }

    public function detail(Request $request){
        return true;
    }

    public function delete(Request $request){
        return true;
    }

 }