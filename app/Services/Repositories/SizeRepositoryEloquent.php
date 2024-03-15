<?php

namespace App\Services\Repositories;


use App\Models\Size;
use App\Services\Interfaces\SizeService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * Class CategoryRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.15
 * 
 *
 * @package namespace App\Services\Repositories;
*/

class SizeRepositoryEloquent implements SizeService {

    /**
     * @var Size
     */
    private Size $size;

    public function __construct(Size $size)
    {
        $this->size = $size;
    }

    public function getAllSize(Request $request){
        try{
            
            $size =  $this->size::orderBy('id', 'ASC');
            $size = $size->get();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $size
            ]); 
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }

}