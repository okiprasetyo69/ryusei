<?php

namespace App\Services\Repositories;

use App\Models\Development;
use App\Services\Interfaces\DevelopmentService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class DevelopmentRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.06.24
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class DevelopmentRepositoryEloquent implements DevelopmentService {
      /**
     * @var Development
     */
    private Development $development;

    public function __construct(Development $development)
    {
        $this->development = $development;
    }

    public function getDevelopment(Request $request){
        try{
            $development = $this->development::orderBy("created_at", "DESC");

            if($request->received_design_date != null){
                $development =  $development->where("received_design_date", $request->received_design_date);
            }

            if($request->sample_date != null){
                $development =  $development->where("sample_date", $request->sample_date);
            }

            $development = $development->get();

            $datatables = Datatables::of($development);
            return $datatables->make( true );
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function update(Request $request){
        try{
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

 }