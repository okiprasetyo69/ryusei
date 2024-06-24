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

class SyncSaleStockRatioJob implements ShouldQueue
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

        Log::info('Sync Process Get Inventory Value For SSR (Sell Stock Ratio) ...');
        $getInventoryValue = $service->syncSaleStockRatio($this->startDate,  $this->endDate);
        Log::info('Finish Sync Get Inventory Value For SSR (Sell Stock Ratio)...');

        // Message queue job has done
        broadcast(new JobCompleted('Sync Sell Stock Ratio has been successed !'));
    }
}
