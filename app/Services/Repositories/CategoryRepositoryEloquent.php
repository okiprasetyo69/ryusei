<?php

namespace App\Services\Repositories;

use App\Models\Category;
use App\Services\Interfaces\CategoryService;

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
 * @since   2024.03.09
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class CategoryRepositoryEloquent implements CategoryService {
    
    /**
     * @var Category
     */
    private Category $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getCategory(Request $request){
        try{
            
            $category = Category::orderBy('name', 'ASC');

            if( ($request->limit != null) && $request->page != null){
                $offset = ($request->page - 1) * $request->limit;

                $category->offset($offset)->limit($request->limit);
            }
          
            if($request->name != null){
                $category->where("name", "like", "%" . $request->name. "%");
            }

            $category = $category->get();

            $datatables = Datatables::of($category);
            return $datatables->make( true );

          
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }

    public function create(Request $request){
        try{
            $category = $this->category;
            $category->fill($request->all());

            if($request->id != null){
                $category = $category::find($request->id);
            }

            $category->name = $request->name;
            $category->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $category
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $category = $this->category::where("id", $request->id)->first();
            if($category == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete category.',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $category = $this->category::where("id", $request->id)->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $category
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }