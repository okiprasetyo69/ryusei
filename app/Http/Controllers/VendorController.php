<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Closure;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Models\Vendor;
use App\Services\Interfaces\VendorService;

class VendorController extends Controller
{
     /**
     * @var Vendor
    */
    
    private VendorService $service;

    public function __construct(VendorService $service) 
    {
        $this->service = $service;
    }


    // WEB
    public function index(Request $request){
        return view("vendors.index");
    }

    public function add(){
        return view("vendors.add");
    }
    
    public function edit(Request $request){
        $vendor = Vendor::find($request->id);
        return view("vendors.detail", compact("vendor"));
    }
    // API

    public function getVendor(Request $request){
        try{
            $vendor = $this->service->getVendor($request);
            if($vendor != null){
                return $vendor;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getVendors(Request $request){
        try{
            $vendors = $this->service->getVendors($request);
            if($vendors != null){
                return $vendors;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            $validator = Validator::make(
                $request->all(), [
                    'name' => 'required',
                ]
            );
    
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 422
                ]);
            }
    
            $vendor = $this->service->create($request);
    
            if($vendor) {
                return $vendor;
            }
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }
    
            $vendor = $this->service->delete($request);
            if($vendor) {
                return $vendor;
            }    
        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'id' => 'required',
            ]);
    
            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors(),
                    'status' => 422
                ]);
            }
    
            $vendor = $this->service->detail($request);
            return $vendor;
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getSupplierFromJubelio(Request $request){
        try{
            $userData = Auth::user();
            $suppliers = $this->service->getSupplierFromJubelio($request, $userData);
            
            if($suppliers != null){
                return $suppliers;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
