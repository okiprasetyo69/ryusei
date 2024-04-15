<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface ItemStockService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.04.15
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface ItemStockService{
    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.15
     * Function for handle requests get stock item.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getItemStock(Request $request);
    
    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since    2024.04.15
     * Function for handle requests create stock item.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.15
     * Function for handle requests delete stock item.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.15
     * Function for handle requests detailstock item.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);
 }