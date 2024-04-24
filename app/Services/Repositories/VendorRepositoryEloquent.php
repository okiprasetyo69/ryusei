<?php

namespace App\Services\Repositories;

use App\Models\Vendor;
use App\Services\Interfaces\VendorService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

/**
 * Class VendorRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.04.23
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class VendorRepositoryEloquent implements VendorService {

     /**
     * @var Vendor
     */
    private Vendor $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function getVendor(Request $request){
        try{
            $vendor =  $this->vendor ;
            
            if($request->name != null){
                $vendor = $vendor->where("name", "like", "%" . $request->name. "%");
            }

            if($request->vendor_code != null){
                $vendor = $vendor->where("vendor_code", "like", "%" . $request->vendor_code. "%");
            }

            if($request->phone != null){
                $vendor = $vendor->where("phone", "like", "%" . $request->phone. "%");
            }

            if($request->mobile != null){
                $vendor = $vendor->where("mobile", "like", "%" . $request->mobile. "%");
            }

            if($request->email != null){
                $vendor = $vendor->where("email", "like", "%" . $request->email. "%");
            }

            if($request->city != null){
                $vendor = $vendor->where("city", "like", "%" . $request->city. "%");
            }

            if($request->id != null){
                $vendor = $vendor->where("id", $request->id);
            }

            if($vendor != null){
                $datatables = Datatables::of( $vendor->get() );
                return $datatables->make( true );
            }
            return false;
            
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getVendors(Request $request){
        try{
            
            $vendor =  $this->vendor ;

            if($request->name != null){
                $vendor  = $vendor->where("name", "like", "%" . $request->name. "%");
            }

            if($request->id != null){
                $vendor  = $vendor->where("id", $request->id);
            }

            $vendor = $vendor->get();
           
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $vendor
            ]); 
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            $vendor = $this->vendor;
            $vendor->fill($request->all());

            if($request->id != null){
                $vendor = $vendor::find($request->id);
            }

            $vendorCode = "";
            if($request->vendor_code == null){
                // genereate Vendor Number
                $prefix = 'V000000';
                $lastId = DB::table('vendors')->latest()->value('id');

                if($lastId == null){
                    $lastId = 0;
                } 
                $lastId = $lastId + 1;

                // Concate Vendor Code
                $vendorCode = $prefix.$lastId;
                //  assign to object
                $vendor->vendor_code = $vendorCode;
            } else {
                $vendor->vendor_code = $request->vendor_code;
            }
          
            $vendor->name = $request->name;
            $vendor->alias = $request->alias;
            $vendor->branch = $request->branch;
            $vendor->category = $request->category;
            $vendor->currency = $request->currency;
            $vendor->phone = $request->phone;
            $vendor->mobile = $request->mobile;
            $vendor->email = $request->email;
            $vendor->is_tax_on_purchase = $request->is_tax_on_purchase;
            $vendor->balance = $request->balance;
            $vendor->city = $request->city;
            
            $vendor->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $vendor
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            try{
                $vendor = $this->vendor::where("id", $request->id)->first();
                if($vendor == null){
                    return response()->json([
                        'data' => null,
                        'message' => 'Data not found',
                        'status' => 400
                    ]);
                }
    
                $vendor->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Success delete vendor.',
                ]);
            }catch(Exception $ex){
                Log::error($ex->getMessage());
                return false;
            }
        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{

            $vendor = $this->vendor::find($request->id);

            if($vendor == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            return response()->json([
                'data' =>  $vendor,
                'message' => 'Success get vendor !',
                'status' => 200
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
         }
    }

 }