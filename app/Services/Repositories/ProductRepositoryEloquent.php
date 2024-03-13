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
use Illuminate\Support\Str;

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

            // convert json string to array
            $products = json_decode($request->products, true);
            $code = "";
            $name = "";

            if($request->code != null){
                $code = $request->code;
                $product = $product::where("code", $request->code);
            } else{
                $code =  Str::random(9);
            }

            if($request->hasFile('image_path')){
                // add new file
                $file = $request->file('image_path');
                $name = $file->getClientOriginalName();
                $image['filePath'] = $name;
                $file->move(public_path().'/uploads/product/', $name);
            }

            foreach ($products as $key => $value) {

                $product = new Product();

                $product->code = $code;
                $product->sku = $value['sku'];
                $product->article = $value['article'];
                $product->name = $request->name;
                $product->size = $value['size'];
                $product->price = $value['price'];
                $product->status = $request->status;
                $product->category_id = $request->category_id;
                $product->image_path = $name;

                $product->save();
            }
            
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

    public function listProduct(Request $request){
        try{
            $product = $this->product::where("code", $request->code)->get();
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

    public function update(Request $request){
        try{

            $product = $this->product;
            $product->fill($request->all());

            // convert json string to array
            $products = json_decode($request->products, true);
            $code = "";
            $name = "";
            $productData = [];
            $arrCode = [];

            if($request->code != null){
                $code = $request->code;
                $product = $product::where("code", $request->code);

                if($request->hasFile('image_path')){
                   
                    if(!empty($request->image_path)){
                        // check exist file
                        $imageProduct = $this->product::where("code", $request->code)->first();
                        $fileName = $imageProduct->image_path;
                        $existFile= File::exists(public_path('uploads/product/'.$fileName.'')); 
                        // remove exist file
                        if($existFile){
                            File::delete(public_path('uploads/product/'.$fileName.''));
                        }
                    }

                    // add new file
                    $file = $request->file('image_path');
                    $name = $file->getClientOriginalName();
                    $image['filePath'] = $name;
                    $file->move(public_path().'/uploads/product/', $name);
                } else {
                    $name = $request->image_path;
                }
                // remove data before insert
                $product->delete();
            } else{
                $code =  Str::random(9);
            }

            foreach ($products as $key => $value) {
                $product = new Product();
                // dd($value);
               
                $product->code = $code;
                $product->sku = $value['sku'];
                $product->article = $value['article'];
                $product->name = $request->name;
                $product->size = $value['size'];
                $product->price = $value['price'];
                $product->status = $request->status;
                $product->category_id = $request->category_id;
                $product->image_path = $name;
               
                // array_push($productData, [
                //     'code' => $code,
                //     'sku'  => $value['sku'],
                //     'article' => $value['article'],
                //     'name' => $request->name,
                //     'size' => $value['size'],
                //     'price' =>  $value['price'], 
                //     'status' =>  $request->status,
                //     'category_id' => $request->category_id,
                //     'image_path' =>  $name
                // ]);
                $product->save();
              
            }
            //$product->save();

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
 }