<?php

namespace App\Services\Repositories;

use App\Models\Vendor;
use App\Services\Interfaces\VendorService;
use App\Models\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


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

    public function getSupplierFromJubelio($userData){
        try{
            // DB::beginTransaction();

            // get all product with actual stock
            $responses = $this->endPointGetSupplier($userData);
            $supplier = $this->vendor;
            
            if($responses->status() == 200){
                $data = $responses->json()['data'];
                foreach ($data as $key => $value) {
    
                   $suppliers = Vendor::where("name", $value['contact_name'])->first();
                   if($suppliers == null){
                        $newSupplier = new Vendor();
                        $newSupplier->name = $value['contact_name'];
                        $newSupplier->phone = $value['phone'];
                        $newSupplier->mobile = $value['mobile'];
                        $newSupplier->email = $value['email'];

                        $newSupplier->save();
                   } else {
                        $suppliers->phone = $value['phone'];
                        $suppliers->mobile = $value['mobile'];
                        $suppliers->email = $value['email'];
                        $suppliers->save();
                   }
                }
            }

            if($responses->status() == 401){
                // $userData = User::where("name" , "Super Admin")->first();
                $relogin = $this->updateTokenApi($userData);
                $responses =  $this->endPointGetSupplier($userData);
            }

            // DB::commit();
            return response()->json([
                'data' =>  $supplier,
                'message' => 'Success upsert suppliers !',
                'status' => 200
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            if($ex->getCode() == 401){
                $relogin = $this->updateTokenApi($userData);
            }
            if($ex->getCode() == 0 || $ex->getCode() == 404){
                $responses = $this->endPointProductItem($userData);
                Log::info("Retry on process ... ");
            }
            return false;
        }
    }

    public function endPointGetSupplier($userData){
        $responses = Http::timeout(10)->retry(3, 1000)->withHeaders([
                        'Authorization' => 'Bearer ' . $userData['api_token'],
                        'Accept' => 'application/json', 
                    ])->get(env('JUBELIO_API') . '/contacts/suppliers/', [
                        'page' => 1,
                        'pageSize' => 200,
                    ]);
        return $responses;
    }

    public function updateTokenApi($userData){
        try{
            // $userData = Auth::user();
            // find current user login
            $users =  User::find($userData['id'])->first();
            // get new token here
            $loginUser =  Http::post(env('JUBELIO_API') . '/login', [
                'email' => env('JUBELIO_EMAIL'),
                'password' => env('JUBELIO_PASSWORD')
            ]);
            
            if($loginUser->status() == 200){
                // try auth login
                $userLogin = $loginUser->json();
                // set new token
                $users->api_token = $userLogin['token'];
            } 
            // update token
            $users->save();
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

 }