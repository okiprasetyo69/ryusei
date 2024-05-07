<?php

namespace App\Services\Repositories;

use App\Models\PurchaseOrder;
use App\Models\User;
use App\Services\Constants\SalesInvoiceConstantInterface;
use App\Services\Constants\WarehouseConstantInterface;
use App\Services\Interfaces\PurchaseOrderService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

/**
 * Class PurchasingOrderRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.04.16
 * 
 *
 * @package namespace App\Services\Repositories;
 */


 class PurchasingInvoiceRepositoryEloquent implements PurchaseOrderService{

    /**
    * @var PurchaseOrder
    */

    private PurchaseOrder $purchaseOrder;

    public function __construct(PurchaseOrder $purchaseOrder)
    {
        $this->purchaseOrder = $purchaseOrder;
    }

    public function getPurchaseOrder(Request $request){
        try{
            $purchaseOrder = $this->purchaseInvoice::with('vendor')->orderBy('date', 'ASC');
            $purchaseOrder = $purchaseInvoice->get();

            $datatables = Datatables::of($purchaseOrder);
            return $datatables->make( true );

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }
 }