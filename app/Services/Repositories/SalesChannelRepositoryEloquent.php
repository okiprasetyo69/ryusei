<?php

namespace App\Services\Repositories;

use App\Models\SalesChannel;
use App\Services\Interfaces\SalesChannelService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * Class SalesChannelRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.16
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class SalesChannelRepositoryEloquent implements SalesChannelService{

     /**
     * @var SalesChannel
     */
    private SalesChannel $salesChannel;

    public function __construct(SalesChannel $salesChannel)
    {
        $this->salesChannel = $salesChannel;
    }

    public function getSalesChannel(Request $request){
        try{
            
            $salesChannel = $this->salesChannel::orderBy('name', 'ASC');
          
            if($request->name != null){
                $salesChannel->where("name", "like", "%" . $request->name. "%");
            }

            $salesChannel = $salesChannel->get();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $salesChannel
            ]); 
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }