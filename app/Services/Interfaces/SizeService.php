<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface CategoryService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.15
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface SizeService {
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.15
     * Function for handle requests get category.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getAllSize(Request $request);
 }