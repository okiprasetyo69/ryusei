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

use App\Models\Locality;
use App\Services\Interfaces\LocalityService;

class LocalityController extends Controller
{
    /**
     * @var Locality
    */
    
    private LocalityService $service;

    public function __construct(LocalityService $service) 
    {
        $this->service = $service;
    }

    public function cityPage(Request $request){
        return view("transaction.city");
    }

    public function importLocalityPage(Request $request){
        return view("transaction.city_import");
    }

    public function getLocality(Request $request){
        try{
            $locality = $this->service->getLocality($request);
            if($locality != null){
                return $locality;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        $validator = Validator::make(
            $request->all(), [
                'postal_code' => 'required',
                'village' => 'required',
                'district' => 'required',
                'city' => 'required',
                'province' => 'required',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $locality = $this->service->create($request);

        if($locality) {
            return $locality;
        }
    }

    public function delete(Request $request){
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

        $locality = $this->service->delete($request);
        if($locality) {
            return $locality;
        }
    }

    public function detail(Request $request){
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

        $locality = $this->service->detail($request);
        return $locality;
    }

    public function importPostalCode(Request $request){
        try{
            $validator = Validator::make(
                $request->all(), [
                    'file_import_postal_code' => 'required|mimes:xls,xlsx'
                ]
            );

            if($validator->fails()){
                return response()->json([
                    'data' => null,
                    'message' => $validator->errors()->first(),
                    'status' => 422
                ]);
            }

            $importPostalCode = $this->service->importPostalCode($request);

            if($importPostalCode) {
                return $importPostalCode;
            }
           
       }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
       }
    }
}
