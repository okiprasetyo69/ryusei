<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface VendorService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.04.23
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 Interface VendorService{
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.23
     * Function for handle requests get vendors.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getVendor(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since    2024.04.23
     * Function for handle requests create vendor.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since    2024.04.23
     * Function for handle requests delete vendor.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.23
     * Function for handle requests detail vendor.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.23
     * Function for handle requests get vendor select2.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getVendorSelect2(Request $request);
 }