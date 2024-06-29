<?php

namespace App\Services\Repositories;

use App\Services\Interfaces\DashboardProductionService;
use App\Services\Constants\DevelopmentConstantInterface;
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
                                        ->whereNotNull("sample_date")
                                        ->whereNull("film_date")
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
                                            ->whereNotNull("received_design_date")
                                            ->whereNull("sample_date")
                                            ->whereNull("film_date")
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

    public function totalFilmDevelopment(Request $request){
        try{
            $totalSampleDevelopment = DB::table("developments")
                                            ->select(DB::raw("COUNT('*') as total_film"))
                                            ->whereNotNull("film_date")
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

    public function totalPoStatus(Request $request){
        try{

            $totalPO = DB::table("developments")
                                            ->select(DB::raw("COUNT('*') as total_po"))
                                            ->where("status", DevelopmentConstantInterface::STATUS_PO)
                                            ->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $totalPO
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalProductionStatus(Request $request){
        try{

            $totalProduction = DB::table("developments")
                                            ->select(DB::raw("COUNT('*') as total_production"))
                                            ->where("status", DevelopmentConstantInterface::STATUS_PRODUCTION)
                                            ->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $totalProduction
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalFilmStatus(Request $request){
        try{

            $totalFilm = DB::table("developments")
                                            ->select(DB::raw("COUNT('*') as total_film"))
                                            ->where("status", DevelopmentConstantInterface::STATUS_FILM)
                                            ->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $totalFilm
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalSamplingStatus(Request $request){
        try{
            $totalSampling = DB::table("developments")
                                            ->select(DB::raw("COUNT('*') as total_sampling"))
                                            ->where("status", DevelopmentConstantInterface::STATUS_SAMPLING)
                                            ->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $totalSampling
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function totalQtyPerCategory(){
        try{
            $totalQtyPerCategory = DB::table("developments")
                                            ->join("categories", "developments.category_id", "=", "categories.id")
                                            ->select("categories.name", DB::raw("SUM(developments.qty) as total_per_category"))
                                            ->groupBy("categories.name");
            $totalQtyPerCategory = $totalQtyPerCategory->orderBy("total_per_category", "DESC")->get();
            $datatables = Datatables::of($totalQtyPerCategory);
            return $datatables->make(true);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }