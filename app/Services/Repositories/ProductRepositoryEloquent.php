<?php

namespace App\Services\Repositories;

use App\Models\Product;
use App\Models\ItemUnit;
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
            
            $product = $this->product::with('category', 'sizes');
          
            if($request->name != null){
                $product = $product->where("name", "like", "%" . $request->name. "%");
            }

            if($request->category_id != null){
                $product = $product->where("category_id", $request->category_id);
            }

            if($request->sku != null){
                $product = $product->where("sku", $request->sku);
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

    public function getPaginateProduct(Request $request){
        try{
            
            $product = $this->product::with('category', 'size')->paginate(6);
          
            if($request->article != null){
                $product->where("article", "like", "%" . $request->article. "%");
            }

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
            $status = 0;

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

            if($request->status != null){
                if($request->status == 1){
                    $status = 1;
                }else{
                    $status = 0;
                }
            }
            foreach ($products as $key => $value) {

                $product = new Product();

                $product->code = $code;
                $product->sku = $value['sku'];
                $product->article = $value['article'];
                $product->name = $request->name;
                $product->size = $value['size'];
                $product->price = $value['price'];
                $product->status = $status;
                $product->category_id = $request->category_id;
                $product->image_path = $name;
                $product->item_unit_id = $request->item_unit_id;
                
                //dd($product);
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

            // $fileName = $product->image_path;
            // $existFile= File::exists(public_path('uploads/product/'.$fileName.'')); 
            // if($existFile){
            //     File::delete(public_path('uploads/product/'.$fileName.''));
            // }
            
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
            $product = $this->product::with('sizes')->where("code", $request->code)->get();
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

            $code = "";
            $name = "";
            $detailsProduct = [];
            $status = 0;

            // convert json string to array
            $products = json_decode($request->products, true);
            $product = $product::where("code", $request->code)->get();
            
            if($request->status != null){
                if($request->status == 1){
                    $status = 1;
                }else{
                    $status = 0;
                }
            }

            // check if have image file
            if($request->code != null){
                $code = $request->code;

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
            } else{
                $code =  Str::random(9);
            }
            

            foreach ($products as $key => $value) {
                $id = null;

                if(!empty($product[$key]["id"])){
                    $id = $product[$key]["id"];
                }
                array_push($detailsProduct, [
                    "id" => $id,
                    "size" => $value['size'],
                    "sku" => $value['sku'],
                    "article" => $value['article'],
                    "price" => $value['price'],
                ]);
            }

            // update product general
            foreach ($product as $k => $val) {
                $productUpdate = Product::find($val->id);

                $productUpdate->code = $code;
                $productUpdate->name = $request->name;
                $productUpdate->status = $status;
                $productUpdate->category_id = $request->category_id;
                $productUpdate->image_path = $name;
                $productUpdate->item_unit_id =  $request->item_unit_id;
                $productUpdate->save();
                // DB::connection()->enableQueryLog();
                $productUpdate->save();
            }

            // UPSERT detail product
            for ($i=0; $i < count($detailsProduct) ; $i++) { 
                $id = $detailsProduct[$i]['id'];

                if( $id != null){
                    // update product item
                    $productDetail = Product::find($id);
                    $productDetail->sku = $detailsProduct[$i]['sku'];
                    $productDetail->article = $detailsProduct[$i]['article'];
                    $productDetail->size = $detailsProduct[$i]['size'];
                    $productDetail->price = $detailsProduct[$i]['price'];

                    $productDetail->save();
                } else {
                    // add new product item per code
                    $product = new Product();
                    $product->code = $code;
                    $product->sku =  $detailsProduct[$i]['sku'];
                    $product->article = $detailsProduct[$i]['article'];
                    $product->name = $request->name;
                    $product->size = $detailsProduct[$i]['size'];
                    $product->price = $detailsProduct[$i]['price'];
                    $product->status = $status;
                    $product->category_id = $request->category_id;
                    $product->image_path = $name;

                    $product->save();
                }
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

    public function getProductSelect2(Request $request){
        try{
            $product = $this->product::where("sku", "like", "%" . $request->input('searchTerm'). "%")
                        ->orderBy('id', 'ASC')
                        ->get(['id', 'sku as text', 'sku'])
                        ->makeHidden(['image_url']);
                        
            return response()->json($product, 200);
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getProductSelect2ForInvoice(Request $request){
        try{
            $product = $this->product;
         
            if($request->category_id != null){
                $product = $product::where("category_id", $request->category_id)->orderBy('id', 'ASC');
            }
               
            $product = $product->get(['id', 'sku as text', 'sku' , 'name'])->makeHidden(['image_url']);
            //dd($product);
            return response()->json($product, 200);
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getItemUnit(Request $request){
        try{
            
            $itemUnit = ItemUnit::all();
           
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $itemUnit
            ]); 
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }