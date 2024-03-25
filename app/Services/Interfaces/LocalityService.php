<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface LocalityService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.22
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface LocalityService{
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.12
     * Function for handle requests get locality.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getLocality(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.12
     * Function for handle requests create locality.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.12
     * Function for handle requests delete locality.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.12
     * Function for handle requests detail locality.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.25
     * Function for handle requests import postal code locality.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function importPostalCode(Request $request);
 }