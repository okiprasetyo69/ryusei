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

use Excel;
use App\Imports\ImportLocality;
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
         
           if($request->postal_code != null){
                $locality = $locality->where("postal_code", "like", "%" . $request->postal_code. "%");
           }
       
            if($request->province != null){
                $locality = $locality->where("province", $request->province);
            }
            
            if($request->city != null){
                $locality =  $locality->where("city", $request->city);
            }

            if($request->district != null){
                $locality =  $locality->where("district", $request->district);
            }

            if($request->village != null){
                $locality =  $locality->where("village", $request->village);
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

   public function importPostalCode(Request $request){
        try{
            $locality = $this->locality;

            if ($request->hasFile('file_import_postal_code')) {
                //GET FILE
                $file = $request->file('file_import_postal_code'); 
                //IMPORT FILE 
                $import = Excel::import(new ImportLocality, $file);
                if($import){
                    return response()->json([
                        'status' => 200,
                        'message' => true,
                        'data' => $locality
                    ]); 
                }
            }  
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
   }

   public function getProvince(Request $request){
        try{
            $locality = $this->locality::select("province as province_name", "province")->orderBy("province", "ASC")->groupBy("province");
            $locality = $locality->get();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $locality
            ]); 

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
   }

   public function getCity(Request $request){
        try{
            $locality = $this->locality::select("city as city_name", "city");
            
            if($request->province != null){
                $locality->where("province", $request->province);
            }
            $locality = $locality->groupBy("city")->get();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $locality
            ]); 

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
   }

   public function getDistrict(Request $request){
        try{
            $locality = $this->locality::select("district as district_name", "district");
            
            if($request->province != null){
                $locality->where("province", $request->province);
            }

            if($request->city != null){
                $locality->where("city", $request->city);
            }

            $locality = $locality->orderBy("district", "ASC")->groupBy("district")->get();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $locality
            ]); 

        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
   }

   public function getVillage(Request $request){
    try{

        $locality = $this->locality::select("*");
        
        if($request->province != null){
            $locality->where("province", $request->province);
        }

        if($request->city != null){
            $locality->where("city", $request->city);
        }

        if($request->district != null){
            $locality->where("district", $request->district);
        }

        $locality = $locality->orderBy("village", "ASC")->get();

        return response()->json([
            'status' => 200,
            'message' => true,
            'data' => $locality
        ]); 

    } catch(Exception $ex){
        Log::error($ex->getMessage());
        return false;
    }
}
}