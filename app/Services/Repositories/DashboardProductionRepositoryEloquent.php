<?php

namespace App\Services\Repositories;

use App\Services\Interfaces\DashboardProductionService;
use App\Models\Development;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class DashboardProductionRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.06.25
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class DashboardProductionRepositoryEloquent implements DashboardProductionService {
    
    /**
    * @var Development
    */
    private Development $development;

    public function __construct(Development $development){
        $this->development = $development;
    }

    public function totalSampleDevelopment(Request $request){
        try{
            $totalSampleDevelopment = DB::table("developments")
                                        ->select(DB::raw("COUNT('*') as total_sample"))
                                        ->first();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $totalSampleDevelopment
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalDesignDevelopment(Request $request){
        try{
            $totalSampleDevelopment = DB::table("developments")
                                            ->select(DB::raw("COUNT('*') as total_design"))
                                            ->where("sample_image", "=", "")
                                            ->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $totalSampleDevelopment
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }