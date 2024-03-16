<?php

namespace App\Services\Repositories;

use App\Models\PaymentMethod;
use App\Services\Interfaces\PaymentMethodService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/**
 * Class PaymentMethodRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.03.16
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class PaymentMethodRepositoryEloquent implements PaymentMethodService{
     /**
     * @var PaymentMethod
     */
    private PaymentMethod $paymentMethod;

    public function __construct(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }
    
    public function getPaymentMethod(Request $request){

        try{
            
            $paymentMethod = $this->paymentMethod::orderBy('name', 'ASC');
          
            if($request->name != null){
                $paymentMethod->where("name", "like", "%" . $request->name. "%");
            }

            $paymentMethod = $paymentMethod->get();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $paymentMethod
            ]); 
        }
        catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }