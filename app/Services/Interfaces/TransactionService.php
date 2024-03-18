<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

/**
 * Interface TransactionService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.03.18
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface TransactionService {
     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.18
     * Function for handle requests get transaction.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function getTransaction(Request $request);

     /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.18
     * Function for handle requests create transaction.
     * 
     * @param Illuminate\Support\Facades\Request
     */
     public function create(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.18
     * Function for handle requests delete transaction.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function delete(Request $request);

    /**
     * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   2024.03.18
     * Function for handle requests detail transaction.
     * 
     * @param Illuminate\Support\Facades\Request
     */
    public function detail(Request $request);
 }