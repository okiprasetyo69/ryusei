<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Repositories\DashboardRepositoryEloquent;
use Illuminate\Support\Facades\Log;
use App\Events\JobCompleted;

class SyncSaleStockRatioDetailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $startDate;
    public $endDate;
    /**
     * Create a new job instance.
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Execute the job.
     */
    public function handle(DashboardRepositoryEloquent $service)
    {
        Log::info('Sync Process SUM of Inventory Value For SSR (Sell Stok Ratio) ...');
        $totalInventoryValue = $service->totalInventoryValue();
        Log::info('Finish Sync SUM of Inventory Value For SSR (Sell Stok Ratio)...');

        Log::info('Sync Process Amount (Omset) of Grand Total From Grand Total For SSR (Sell Stok Ratio) ...');
        $totalSalesTurnOver = $service->totalSalesTurnOver();
        Log::info('Finish Sync Amount (Omset)  of Grand Total From Grand Total For SSR (Sell Stok Ratio)...');

        // Message queue job has done
        broadcast(new JobCompleted('Sync Sell Stock Ratio Detail has been successed !'));
    }
}
