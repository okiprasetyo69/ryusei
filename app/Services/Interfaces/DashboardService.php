<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface DashboardService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.20
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface DashboardService {
      /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.20
     * Function for handle requests get total item sold.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function totaPerItemSold(Request $request);
 }