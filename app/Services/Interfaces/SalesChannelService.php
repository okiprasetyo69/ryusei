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
 }