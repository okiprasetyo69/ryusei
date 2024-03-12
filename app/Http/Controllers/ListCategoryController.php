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

use App\Models\CategoryList;
use App\Services\Interfaces\CategoryListService;

class ListCategoryController extends Controller
{
    /**
     * @var CategoryList
    */
    
    private CategoryListService $service;

    public function __construct(CategoryListService $service) 
    {
        $this->service = $service;
    }

    public function index(Request $request){
        return view("category_list.index");
    }

    public function getListCategory(Request $request){
        try{
            $categoryList = $this->service->getListCategory($request);
            if($categoryList != null){
                return $categoryList;
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
                'list_name' => 'required',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $listCategory = $this->service->create($request);

        if($listCategory) {
            return $listCategory;
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

        $categoryList = $this->service->delete($request);
        if($categoryList) {
            return $categoryList;
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

        $listCategory = $this->service->detail($request);
        return $listCategory;
    }



}
