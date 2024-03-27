<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; 
use App\Models\Product;
use App\Models\SalesChannel;
use App\Models\Transaction;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ImportTransaction implements ToModel, WithHeadingRow 
{
    protected $order_date, $process_order_date, $sales_channel_id, $group_id, $payment_method_id;

    public function __construct($order_date, $process_order_date, $sales_channel_id, $group_id, $payment_method_id)
    {
        $this->order_date = $order_date;
        $this->process_order_date = $process_order_date;
        $this->sales_channel_id = $sales_channel_id;
        $this->group_id = $group_id;
        $this->payment_method_id = $payment_method_id;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        try{

            $order_date =  $this->order_date;
            $process_order_date =  $this->process_order_date;
            $sales_channel_id = $this->sales_channel_id;
            $group_id = $this->group_id;
            $payment_method_id = $this->payment_method_id;
    
            // find SKU ID
            $product = Product::where("sku", $row['kode_sku'])->first();
            $skuId = $product->id;
            $productPrice = $product->price;

            // Calculate total price
            $total = $row['qty'] * $row['harga_sat'];
    
            // find admin charge
            $salesChannel =  SalesChannel::where("id",  $sales_channel_id)->first();
            $percentageAdminCharge =  $salesChannel->admin_charge;
            $yearAdminSalesChannel = $salesChannel->year;

            $adminCharge =  intval(($row['qty'] *  $row['harga_sat']) * ($salesChannel->admin_charge/100));

            // calculate discount
            $unitPrice = $row['harga_sat'];
            $discount = (1 -  $unitPrice / $productPrice) * 100 ;
            
            // calculate total net (total bersih)
            $totalNet = $total - ($total * ($salesChannel->admin_charge / 100));
            //  dd($totalNet);
    
            return new Transaction([
                'sales_channel_id' => $sales_channel_id,
                'order_number' => $row['no_order'],
                'tracking_number' =>$row['tracking_number'],
                'sku_id' => $skuId,
                'qty' => $row['qty'],
                'unit_price' => $row['harga_sat'],
                'order_date' => $order_date,
                'process_order_date' => $process_order_date,
                'group_id' => $group_id,
                'payment_method_id' => $payment_method_id,
                'postal_code' => $row['kode_pos'],
                'total' =>  $total,
                'admin_charge' => $adminCharge,
                'total_net' => $totalNet,
                'discount' => $discount,
                'percentage_admin_charge' =>  $percentageAdminCharge,
                'year_admin_sales_channel' => $yearAdminSalesChannel,
            ]);
        } catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
      
    }
}
