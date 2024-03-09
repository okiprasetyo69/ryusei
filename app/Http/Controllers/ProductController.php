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

    public function create(Request $request){}
    public function detail(Request $request){}
    public function delete(Request $request){}
}
