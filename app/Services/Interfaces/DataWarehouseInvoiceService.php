<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;


/**
 * Interface DataWarehouseInvoiceService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.05.13
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface DataWarehouseInvoiceService{
    /**
   * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
   * @since   2024.05.13
   * Function for handle requests get data warehouse invoice.
   * 
   * @param Illuminate\Support\Facades\Request
   */
  public function getDataWareHouseInvoice(Request $request);

}