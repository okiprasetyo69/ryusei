<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface CategoryListService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.12
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface CategoryListService{
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.12
     * Function for handle requests get category list.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getListCategory(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.12
     * Function for handle requests create category list.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.12
     * Function for handle requests delete category list.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.12
     * Function for handle requests detail category list.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);
 }