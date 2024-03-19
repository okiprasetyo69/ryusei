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

use App\Models\SalesChannel;
use App\Services\Interfaces\SalesChannelService;

class SalesChannelController extends Controller
{

    /**
     * @var SalesChannel
    */
    
    private SalesChannelService $service;

    public function __construct(SalesChannelService $service) 
    {
        $this->service = $service;
    }

    public function salesChannelPage(Request $request){
        return view("transaction.setting_sales_channel");
    }

    public function getSalesChannel(Request $request){
        try{
            
            $salesChannelList = $this->service->getSalesChannel($request);
            if($salesChannelList != null){
                return $salesChannelList;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function getSalesChannelDatatable(Request $request){
        try{
            
            $salesChannelList = $this->service->getSalesChannelDatatable($request);
            if($salesChannelList != null){
                return $salesChannelList;
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
                'name' => 'required',
                'code' => 'required',
                'admin_charge' => 'required',
                'year' => 'required',
            ]
        );

        if($validator->fails()){
            return response()->json([
                'data' => null,
                'message' => $validator->errors()->first(),
                'status' => 422
            ]);
        }

        $salesChannel = $this->service->create($request);

        if($salesChannel) {
            return $salesChannel;
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

        $salesChannel = $this->service->delete($request);
        if($salesChannel) {
            return $salesChannel;
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

        $salesChannel = $this->service->detail($request);
        return $salesChannel;
    }
}
