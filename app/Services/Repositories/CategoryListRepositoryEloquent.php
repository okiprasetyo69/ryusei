<?php

namespace App\Services\Repositories;

use App\Models\CategoryList;
use App\Services\Interfaces\CategoryListService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;



/**
 * Class CategoryRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.12
 * 
 *
 * @package namespace App\Services\Repositories;
*/

class CategoryListRepositoryEloquent implements CategoryListService {
     /**
     * @var CategoryList
     */
    private CategoryList $categoryList;

    public function __construct(CategoryList $categoryList)
    {
        $this->categoryList = $categoryList;
    }

    public function getListCategory(Request $request){
        try{
            
            $categoryList =  $this->categoryList::with('category')->orderBy('list_name', 'ASC');
          
            if($request->list_name != null){
                $categoryList->where("list_name", "like", "%" . $request->list_name. "%");
            }

            $categoryList = $categoryList->get();

            $datatables = Datatables::of($categoryList);
            return $datatables->make( true );
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }

    public function create(Request $request){
        try{
            $listCategory = $this->categoryList;
            $listCategory->fill($request->all());

            if($request->id != null){
                $listCategory = $listCategory::find($request->id);
            }

            $listCategory->list_name = $request->list_name;
            $listCategory->category_id = $request->category_id;
            $listCategory->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $listCategory
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $categoryList = $this->categoryList::where("id", $request->id)->first();
            if($categoryList == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $categoryList->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete list category.',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $listCategory = $this->categoryList::where("id", $request->id)->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $listCategory
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}