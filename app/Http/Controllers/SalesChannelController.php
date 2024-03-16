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
}
