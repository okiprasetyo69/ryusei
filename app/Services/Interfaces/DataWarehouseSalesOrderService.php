<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;


/**
 * Interface DataWarehouseSalesOrderService.
 * 
 * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
 * @since   2024.05.15
 * 
 *
 * @package namespace App\Services\Interfaces;
 */

 interface DataWarehouseSalesOrderService{
    /**
   * @author Oki Prasetyo <oki.prasetyo45@gmail.com>
   * @since   2024.05.15
   * Function for handle requests get data sales orders.
   * 
   * @param Illuminate\Support\Facades\Request
   */
  public function getDataWareHouseSalesOrder(Request $request);

}