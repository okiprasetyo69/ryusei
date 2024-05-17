<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface SalesReturnService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.04.17
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface SalesReturnService{
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.17
     * Function for handle requests get sales retur.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getAllSalesReturn(Request $request);
 }