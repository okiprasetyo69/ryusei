<?php

namespace App\Services\Repositories;

use App\Models\Product;
use App\Services\Interfaces\ImportProductService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Excel;
use App\Imports\ImportProduct;
use Illuminate\Support\Str;

/**
 * Class ImportProductRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.12
 * 
 *
 * @package namespace App\Services\Repositories;
*/

class ImportProductRepositoryEloquent implements ImportProductService {
        /**
     * @var Product
     */
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function importProduct(Request $request){
        try{
            
            $product = $this->product;
            $code = Str::random(9);
            $imageName = "";

            if($request->hasFile('image_path')){
                $file = $request->file('image_path');
                $imageName = $file->getClientOriginalName();
                $image['filePath'] = $imageName;
                $file->move(public_path().'/uploads/product/', $imageName);
            }
            
            if ($request->hasFile('file_import_product')) {
                //GET FILE
                $file = $request->file('file_import_product'); 
                //IMPORT FILE 
                $import = Excel::import(new ImportProduct($code, $request->category_id, $request->name, $request->status, $imageName), $file);
                if($import){
                    return response()->json([
                        'status' => 200,
                        'message' => true,
                        'data' => $product
                    ]); 
                }
            }  

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
        
    }
}