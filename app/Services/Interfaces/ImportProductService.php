<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface CategoryListService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.25
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface ImportProductService{
      /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.25
     * Function for handle requests import product xlsx or xls.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function importProduct(Request $request);
 }