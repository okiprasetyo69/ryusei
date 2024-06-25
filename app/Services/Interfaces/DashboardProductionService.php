<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface DashboardProductionService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.06.25
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface DashboardProductionService {
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.06.25
     * Function for handle requests get total sample development.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function totalSampleDevelopment(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.06.25
     * Function for handle requests get total design development.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function totalDesignDevelopment(Request $request);
 }