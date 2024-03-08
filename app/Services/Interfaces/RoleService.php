<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface RoleService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.08
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface RoleService {
    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.08
     * Function for handle requests get role users.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getRole(Request $request);
 }