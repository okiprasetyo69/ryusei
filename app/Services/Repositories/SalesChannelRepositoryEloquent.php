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
use Yajra\DataTables\Facades\DataTables;

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
                $salesChannel  = $salesChannel->where("name", "like", "%" . $request->name. "%");
            }

            if($request->id != null){
                $salesChannel  = $salesChannel->where("id", $request->id);
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

    public function getSalesChannelDatatable(Request $request){
        try{
            
            $salesChannel = $this->salesChannel::orderBy('code', 'ASC');
          
            if($request->name != null){
                $salesChannel  = $salesChannel->where("name", "like", "%" . $request->name. "%");
            }

            $salesChannel = $salesChannel->get();

            $datatables = Datatables::of($salesChannel);
            return $datatables->make( true );
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            $salesChannel = $this->salesChannel;
            $salesChannel->fill($request->all());

            if($request->id != null){
                $salesChannel = $salesChannel::find($request->id);
            }

            $salesChannel->code = $request->code;
            $salesChannel->name = $request->name;
            $salesChannel->admin_charge = $request->admin_charge;
            $salesChannel->year = $request->year;
            $salesChannel->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $salesChannel
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $salesChannel = $this->salesChannel::where("id", $request->id)->first();

            if($salesChannel == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $salesChannel->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete sales channel.',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function detail(Request $request){
        try{
            $salesChannel = $this->salesChannel::where("id", $request->id)->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $salesChannel
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }