<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface InvoiceCategoryService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.04.16
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface InvoiceCategoryService {
    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.16
     * Function for handle requests get invoice category.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getInvoiceCategory(Request $request);
 }