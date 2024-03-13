<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface ProductService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.09
 * 
 *
 * @package namespace App\Services\Interfaces;
 */
interface ProductService {
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.09
     * Function for handle requests get product.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getProduct(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.09
     * Function for handle requests get create.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.09
     * Function for handle requests detail product.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.09
     * Function for handle requests delete product.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);
    
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.13
     * Function for handle requests get list product.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function listProduct(Request $request);

      /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.13
     * Function for handle requests update list product.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function update(Request $request);
}