<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface UserService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.08
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface UserService {
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.08
     * Function for handle requests get users.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getUser(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.08
     * Function for handle requests create user.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.08
     * Function for handle requests delete user.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.08
     * Function for handle requests detail user.
     * 
     * @param Illuminate\Support\Facades\Request
     */

     public function detail(Request $request);

 }