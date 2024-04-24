<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface PurchasingInvoiceService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.04.24
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface PurchasingInvoiceService{
    /**
    * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
    * @since    2024.04.24
    * Function for handle requests get purchasing invoice.
    * 
    * @param Illuminate\Support\Facades\Request
    */
   public function getPurchasingInvoice(Request $request);

    /**
    * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
    * @since    2024.04.24
    * Function for handle requests create purchasing invoice.
    * 
    * @param Illuminate\Support\Facades\Request
    */
   public function create(Request $request);

    /**
    * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
    * @since    2024.04.24
    * Function for handle requests delete purchasing invoice.
    * 
    * @param Illuminate\Support\Facades\Request
    */
   public function delete(Request $request);

    /**
    * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
    * @since    2024.04.24
    * Function for handle requests detail purchasing invoice.
    * 
    * @param Illuminate\Support\Facades\Request
    */
   public function detail(Request $request);
}