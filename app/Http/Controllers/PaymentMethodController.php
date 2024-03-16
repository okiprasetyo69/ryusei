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

use App\Models\PaymentMethod;
use App\Services\Interfaces\PaymentMethodService;

class PaymentMethodController extends Controller
{
     /**
     * @var PaymentMethod
    */
    
    private PaymentMethodService $service;

    public function __construct(PaymentMethodService $service) 
    {
        $this->service = $service;
    }

    public function getPaymentMethod(Request $request){
        try{
            $paymentMethod = $this->service->getPaymentMethod($request);
            if($paymentMethod != null){
                return $paymentMethod;
            }
            return false;
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
}
