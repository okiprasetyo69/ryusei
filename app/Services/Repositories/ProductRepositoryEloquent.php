<?php

namespace App\Services\Repositories;

use App\Models\Product;
use App\Models\ItemUnit;
use App\Models\User;
use App\Models\ItemStock;
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
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

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

    /**
     * @var User
     */
    private User $user;

    public function __construct(Product $product, User $user)
    {
        $this->product = $product;
        $this->user = $user;
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
            $product = $this->product::where("sku", "like", "%" . $request->input('searchTerm'). "%")->orderBy('id', 'ASC');
           
            if($request->category_id != null){
              $product = $product->where("category_id", $request->category_id);
            }

            if($request->sku_id != null){
                $product = $product->where("id", $request->sku_id);
            }
               
            $product = $product->get(['id', 'sku as text', 'sku' , 'name', 'article', 'price'])->makeHidden(['image_url']);
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

    public function getProductFromJubelio(Request $request, $userData){
        try{
            DB::beginTransaction();
            
            // upsert actual data product
            // $upsertProduct = $this->updateProductItem($userData);
            // $upsertItemProduct = $this->updateItemProduct($userData);
            // $upsertItemBundling = $this->updateItemBundling($userData);
            // SyncProductJob::dispatch();

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Data product success updated !',
            ]);
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
    
    public function updateProductItem($userData){
        try{

            $responses = Http::withHeaders([
                'Authorization' => 'Bearer ' . $userData['api_token'],
                'Accept' => 'application/json', 
            ])->get(env('JUBELIO_API') . '/inventory/');
            
            if($responses->failed() == true){
                $responses = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $userData['api_token'],
                    'Accept' => 'application/json', 
                ])->get(env('JUBELIO_API') . '/inventory/');
            }

            $today = date('Y-m-d');

            if($responses->status() == 200){
                $data = $responses->json()['data'];
                foreach ($data as $k => $value) {
                    // Check exist product
                    Log::info('Update Product with item code - ' . $value['item_code']);

                    $product = Product::where("sku", $value['item_code'])->first();
                    if($product == null){
                        $newProduct = new Product();
                        $newProduct->code = $value['item_group_id'];
                        $newProduct->sku = $value['item_code'];

                        if($value['variation_values'] != null){
                            $newProduct->article =   $value['item_name'] . ' - ' . $value['variation_values'][0]['value'];
                        } else {
                            $newProduct->article  = null;
                        }

                        $newProduct->name = $value['item_name'];
                        $newProduct->save();

                        $newStock = new ItemStock();
                        $newStock->sku_id =  $newProduct->id;
                        $newStock->check_in_date =  $today;
                        $newStock->qty =  $value['total_stocks']['available'];
                        $newStock->save();
                    }  
    
                    if($product != null){

                        $product->code = $value['item_group_id'];
                        $product->sku = $value['item_code'];

                        if($value['variation_values'] != null){
                            $product->article =   $value['item_name'] . ' - ' . $value['variation_values'][0]['value'];
                        } else {
                            $product->article  = null;
                        }
                        $product->name = $value['item_name'];
                        // Check exist stock item product
                        $itemStock = ItemStock::where("sku_id", $product->id)->first();
                        if($itemStock == null){
                            $newItemStock = new ItemStock();
                            $newItemStock->sku_id = $product->id;
                            $newItemStock->sku_code = $value['item_code'];
                            $newItemStock->qty =  $value['total_stocks']['available'];
                            $newItemStock->check_in_date =   $today;
                            $newItemStock->save();
                        } else {
                            $itemStock->sku_code = $value['item_code'];
                            $itemStock->qty =  $value['total_stocks']['available'];
                            $itemStock->check_in_date =  $today;
                            $itemStock->save();
                        }
                        $product->save();
                    }
                }
            }

            if($responses->status() == 401){
                $relogin = $this->updateTokenApi($userData);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data product success updated !',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            if($ex->getCode() == 0 || $ex->getCode() == 404){
                $responses = $this->endPointProductItem($userData);
                Log::info("Retry on process ... ");
            }
            return false;
        }
    }

    public function updateItemProduct($userData){
        try{

            // get item detail to get price per item
            $itemsResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' .  $userData['api_token'],
                'Accept' => 'application/json', 
            ])->get(env('JUBELIO_API') . '/inventory/items/');

            if($itemsResponse->failed() == true){
                $itemsResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' .  $userData['api_token'],
                    'Accept' => 'application/json', 
                ])->get(env('JUBELIO_API') . '/inventory/items/');
            }

            if($itemsResponse->status() == 200){
                $data = $itemsResponse->json()['data'];
                foreach ($data as $k => $val) {
                    $detailItem = $val['variants'];
                    foreach ($detailItem as $key => $value) {
                        Log::info('Update Produtct per Item with item code - ' . $value['item_code']);

                        $productPrice = Product::where("sku", $value['item_code'])->first();
                        if($productPrice == null ){
                            $newProductPrice = new Product();
                            $newProductPrice->code = $value['item_group_id'];
                            $newProductPrice->name = $value['item_name'];
                            $newProductPrice->price = $value['sell_price'];
                            $newProductPrice->save();
                        } else {
                            $productPrice->price = $value['sell_price'];
                            $productPrice->save();
                        }
                    }
                }
            } 
            
            if($itemsResponse->status() == 401){
                $relogin = $this->updateTokenApi($userData);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data Item product success updated !',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function updateItemBundling($userData){
        try{
            // get price per bundle
            $itemsBundleResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' .  $userData['api_token'],
                'Accept' => 'application/json', 
            ])->get(env('JUBELIO_API') . '/inventory/item-bundles/');

            if($itemsBundleResponse->failed() == true){
                $itemsBundleResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $userData['api_token'],
                    'Accept' => 'application/json', 
                ])->get(env('JUBELIO_API') . '/inventory/');
            }

            if($itemsBundleResponse->status() == 200){
                $data = $itemsBundleResponse->json()['data'];
                foreach ($data as $k => $val) {
                    $variants = $val['variants'];
                    foreach ($variants as $key => $value) {
                        Log::info('Update Product per Item Bundling with item code - ' . $value['item_code']);

                        $productPrice = Product::where("sku", $value['item_code'])->first();
                        if($productPrice == null ){
                            $newProductPrice = new Product();
                            $newProductPrice->code = $value['item_group_id'];
                            $newProductPrice->name = $value['item_name'];
                            $newProductPrice->price = $value['sell_price'];
                            $newProductPrice->save();
                        } else {
                            $productPrice->price = $value['sell_price'];
                            $productPrice->save();
                        }
                    }
                }
            }

            if($itemsBundleResponse->status() == 401){
                $relogin = $this->updateTokenApi($userData);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Data item bundling product success updated !',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function endPointProductItem($userData){
        $responses = Http::withHeaders([
            'Authorization' => 'Bearer ' . $userData['api_token'],
            'Accept' => 'application/json', 
        ])->get(env('JUBELIO_API') . '/inventory/');
        
        return $responses;

    }

    public function updateTokenApi($userData){
        try{
            // $userData = Auth::user();
            // find current user login
            $users =  User::find($userData['id'])->first();
            // get new token here
            $loginUser =  Http::post(env('JUBELIO_API') . '/login', [
                'email' => env('JUBELIO_EMAIL'),
                'password' => env('JUBELIO_PASSWORD')
            ]);
            
            if($loginUser->status() == 200){
                // try auth login
                $userLogin = $loginUser->json();
                // set new token
                $users->api_token = $userLogin['token'];
            } 
            // update token
            $users->save();
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    private function convertSize($data = null){
        $size = 0;
        switch ($value['variation_values'][$k]['value']) {
            case 'S' :
                $size = 1;
                break;
            case 'M':
                $size = 2;
                break;
            case 'L':
                $size = 3;
                break;
            case 'XS':
                $size = 4;
                break;
            case 'XL':
                $size = 5;
                break;
            case 'XXL':
                $size = 6;
                break;
            case '3XL':
                $size = 7;
                break;
            case 'FS':
                $size = 8;
                break;
            case '26':
                $size = 9;
                break;
            case '27':
                $size = 10;
                break;
            case '28':
                $size = 11;
                break;
            case '29':
                $size = 12;
                break;
            case '30':
                $size = 13;
                break;
            case '31':
                $size = 14;
                break;
            case '32':
                $size = 15;
                break;
            case '33':
                $size = 16;
                break;
            case '34':
                $size = 17;
                break;
            case '35':
                $size = 18;
                break;
            case '36':
                $size = 19;
                break;
            case '37':
                $size = 20;
                break;
            case '38':
                $size = 21;
                break;
            case '39':
                $size = 22;
                break;
            case '40':
                $size = 23;
                break;
            case '41':
                $size = 24;
                break;
            case '42':
                $size = 25;
                break;
            case '43':
                $size = 26;
                break;
            case '44':
                $size = 27;
                break;
            case 'All Size':
                $size = 28;
                break;
            case 'A':
                $size = 29;
                break;
            case 'B':
                $size = 30;
                break;
            case '4':
                $size = 31;
                break;
            case '5':
                $size = 32;
                break;
            case '6':
                $size = 33;
                break;
            case '7':
                $size = 34;
                break;
            case '8':
                $size = 35;
                break;
            case '9':
                $size = 36;
                break;
            case '10':
                $size = 37;
                break;
            case '11':
                $size = 38;
                break;
            case '12':
                $size = 39;
                break;
            case '13':
                $size = 40;
                break;
            case '14':
                $size = 41;
                break;
            default:
                $size = 0;
                break;
        }

        return $size;
    }
 }