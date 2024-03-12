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

    public function index(Request $request){
        return view("product.index");
    }

    public function add(Request $request){
        return view("product.add");
    }

    public function edit(Request $request){
        $product = Product::where("id", $request->id)->first();
        return view("product.edit",  compact('product'));
    }

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

    public function create(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'code' => 'required',
                'article' => 'required',
                'sku' => 'required',
                'size' => 'required',
                'price' => 'required',
                'category_id' => 'required',
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
    public function delete(Request $request){}
}
