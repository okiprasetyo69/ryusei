<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface PurchaseOrderService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.05.07
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface PurchaseOrderService{
    /**
    * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
    * @since   2024.05.07
    * Function for handle requests get purchasing order.
    * 
    * @param Illuminate\Support\Facades\Request
    */
   public function getPurchaseOrder(Request $request);
 }