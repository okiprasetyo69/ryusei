<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface SalesInvoiceService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.04.16
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface SalesInvoiceService{
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.16
     * Function for handle requests get sales invoice.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getSalesInvoice(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.16
     * Function for handle requests create sales invoice.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function create(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.16
     * Function for handle requests delete sales invoice.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.04.16
     * Function for handle requests detail sales invoice.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);
 }