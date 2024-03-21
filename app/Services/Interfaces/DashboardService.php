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
     * @since   2024.03.21
     * Function for handle requests get total item sold.
     * 
     * @param Illuminate\Support\Facades\Request
     */
      public function totalQty(Request $request);

      /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.21
     * Function for handle requests get best store.
     * 
     * @param Illuminate\Support\Facades\Request
     */
      public function bestSellingChannelStore(Request $request);

      /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.21
     * Function for handle requests get best selling product.
     * 
     * @param Illuminate\Support\Facades\Request
     */
      public function bestSellingProduct(Request $request);

        /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.21
     * Function for handle requests chart selling.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getChartSelling(Request $request);

 }