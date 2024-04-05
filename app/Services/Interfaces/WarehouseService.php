<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface WarehouseService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.04.05
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface WarehouseService {
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.05
     * Function for handle requests get warehouse.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getWarehouse(Request $request);
    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.05
     * Function for handle requests create warehouse.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.05
     * Function for handle requests delete warehouse.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.05
     * Function for handle requests detail warehouse.
     * 
     * @param Illuminate\Support\Facades\Request
     */
     public function detail(Request $request);
 }