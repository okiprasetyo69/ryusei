<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface CategoryService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.09
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface CategoryService {
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.09
     * Function for handle requests get category.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getCategory(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.09
     * Function for handle requests create category.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.09
     * Function for handle requests delete category.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.09
     * Function for handle requests detail category.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);
 }