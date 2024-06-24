<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface DevelopmentService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.06.24
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface DevelopmentService{
    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.06.24
     * Function for handle requests get development list.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getDevelopment(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since  2024.06.24
     * Function for handle requests create development list.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since  2024.06.24
     * Function for handle requests update development list.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function update(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.06.24
     * Function for handle requests delete development.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since  2024.06.24
     * Function for handle requests detail development.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);
 }