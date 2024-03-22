<?php

namespace App\Services\Repositories;

use App\Models\Locality;
use App\Services\Interfaces\LocalityService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class LocalityRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.12
 * 
 *
 * @package namespace App\Services\Repositories;
*/

class LocalityRepositoryEloquent implements LocalityService {
    /**
    * @var Locality
    */
   private Locality $locality;

   public function __construct(Locality $locality)
   {
       $this->locality = $locality;
   }

   public function getLocality(Request $request){
       try{
           
           $locality =  $this->locality;
         
           if($request->city != null){
               $locality->where("city", "like", "%" . $request->city. "%");
           }

           $locality = $locality->get();

           $datatables = Datatables::of($locality);
           return $datatables->make( true );
       }
       catch(Exception $ex){
           Log::error($ex->getMessage());
           return false;
        }
   }

   public function create(Request $request){
       try{
           $locality = $this->locality;
           $locality->fill($request->all());

           if($request->id != null){
               $locality = $locality::find($request->id);
           }

           $locality->postal_code = $request->postal_code;
           $locality->village = $request->village;
           $locality->district = $request->district;
           $locality->city = $request->city;
           $locality->province = $request->province;

           $locality->save();

           return response()->json([
               'status' => 200,
               'message' => true,
               'data' => $locality
           ]); 
       }catch(Exception $ex){
           Log::error($ex->getMessage());
           return false;
       }
   }

   public function delete(Request $request){
       try{
           $locality = $this->locality::where("id", $request->id)->first();
           if($locality == null){
               return response()->json([
                   'data' => null,
                   'message' => 'Data not found',
                   'status' => 400
               ]);
           }

           $locality->delete();
           return response()->json([
               'status' => 200,
               'message' => 'Success delete locality.',
           ]);

       }catch(Exception $ex){
           Log::error($ex->getMessage());
           return false;
       }
   }

   public function detail(Request $request){
       try{
           $locality = $this->locality::where("id", $request->id)->first();
           return response()->json([
               'status' => 200,
               'message' => true,
               'data' => $locality
           ]);
       }catch(Exception $ex){
           Log::error($ex->getMessage());
           return false;
       }
   }
}