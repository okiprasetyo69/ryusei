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

use App\Models\Category;
use App\Services\Interfaces\CategoryService;

class CategoryController extends Controller
{
    /**
     * @var Category
    */
    
    private CategoryService $service;

    public function __construct(CategoryService $service) 
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return view("category.index");
    }

    public function getCategory(Request $request){
        try{
            $category = $this->service->getCategory($request);
            if($category != null){
                return $category;
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
            ]
        );

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $category = $this->service->create($request);

        if($category) {
            return $category;
        }
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

        $category = $this->service->delete($request);
        if($category) {
            return $category;
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

        $category = $this->service->detail($request);
        return $category;
    }
}
