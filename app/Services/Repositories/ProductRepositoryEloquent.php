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
use Illuminate\Support\Facades\File; 

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
        try{
     
            $product = $this->product;
            $product->fill($request->all());

            if($request->id != null){
                $product = $product::find($request->id);
            }

            $product->code = $request->code;
            $product->article = $request->article;
            $product->sku = $request->article;
            $product->size = $request->size;
            $product->price = $request->price;
            $product->status = $request->status;
            $product->category_id = $request->category_id;

            if($request->hasFile('image_path')){
                $file = $request->file('image_path');
                $name = $file->getClientOriginalName();
                $image['filePath'] = $name;
                $file->move(public_path().'/uploads/product/', $name);
                $product->image_path= $name;
            }

            $product->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $product
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $product = $this->product::where("id", $request->id)->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $product
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{

            $product = $this->product::where("id", $request->id)->first();
            if($product == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $fileName = $product->image_path;
            $existFile= File::exists(public_path('uploads/product/'.$fileName.'')); 
            if($existFile){
                File::delete(public_path('uploads/product/'.$fileName.''));
            }
            
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete product .',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

 }