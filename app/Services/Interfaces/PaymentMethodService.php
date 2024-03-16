<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface PaymentMethodService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.16
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface PaymentMethodService {
    /**
    * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
    * @since   2024.03.16
    * Function for handle requests get payment method.
    * 
    * @param Illuminate\Support\Facades\Request
    */
   public function getPaymentMethod(Request $request);
}