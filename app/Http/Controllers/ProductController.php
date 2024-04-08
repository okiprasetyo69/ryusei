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

use App\Models\Product;
use App\Models\Size;
use App\Models\Category;
use App\Services\Interfaces\ProductService;

class ProductController extends Controller
{
    /**
     * @var Product
    */
    
    private ProductService $service;

    public function __construct(ProductService $service) 
    {
        $this->service = $service;
    }

     // View
    public function index(Request $request){
        
        $category = Category::all();
        $size = Size::all();
        $query = Product::query();
    
        if($request->filter_article != null){
          $query->where("article", "like", "%" . $request->filter_article. "%");
        }

        if($request->category_id != null){
            $query->where("category_id", $request->category_id);
        }

        if($request->size != null){
           $query->where("size", $request->size);
        }

        if($request->price != null){
            if($request->price == 1){
                $query->orderBy("price","ASC");
            }
            if($request->price == 2){
               $query->orderBy("price","DESC");
            }
           
        }
        $data = $query->with('category', 'sizes')->paginate(6);

        return view("product.index", ["data" => $data, "category" => $category, "size" => $size]);
    }


    public function add(Request $request){
        return view("product.add");
    }

    public function edit(Request $request){
        $product = Product::where("code", $request->code)->first();
        $products = Product::with("sizes")->where("code", $request->code)->get();
        $size = Size::all();
        return view("product.edit",  compact('product', 'products', 'size'));
    }

    public function downloadFormatImportProduct(){
        $path = public_path('/import/Format_Import_Product.xlsx');
        return response()->download($path);
    }

    // Api data
    public function getProduct(Request $request){
        try{
            $product = $this->service->getProduct($request);
            if($product != null){
                return $product;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getPaginateProduct(Request $request){
        try{
            $product = $this->service->getPaginateProduct($request);
            if($product != null){
                return $product;
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
                'products'  => 'required',
                'category_id'  => 'required',
            ]
        );
        
        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $product = $this->service->create($request);

        if($product) {
            return $product;
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

        $product = $this->service->detail($request);
        return $product;
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

        $product = $this->service->delete($request);
        return $product;
    }

    public function listProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors(),
                'status' => 422
            ]);
        }

        $product = $this->service->listProduct($request);
        return $product;
    }

    public function update(Request $request){
       
        $validator = Validator::make(
            $request->all(), [
                'name' => 'required',
                'products'  => 'required',
                'category_id'  => 'required',
            ]
        );
        
        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $product = $this->service->update($request);

        if($product) {
            return $product;
        }
    }

    public function getProductSelect2(Request $request){
        try{
            $product = $this->service->getProductSelect2($request);
            if($product != null){
                return $product;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getProductSelect2Invoice(Request $request){
        try{
            $product = $this->service->getProductSelect2ForInvoice($request);
            if($product != null){
                return $product;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getItemUnit(Request $request){
        try{
            $itemUnit = $this->service->getItemUnit($request);
            if($itemUnit != null){
                return $itemUnit;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
