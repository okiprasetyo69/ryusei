<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface SalesChannelService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.16
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface SalesChannelService {
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.16
     * Function for handle requests get sales  channel.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getSalesChannel(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.19
     * Function for handle requests create sales channel.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.19
     * Function for handle requests delete sales channel.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.19
     * Function for handle requests detail sales channel.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.19
     * Function for handle requests get sales channel format datatable.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getSalesChannelDatatable(Request $request);
 }