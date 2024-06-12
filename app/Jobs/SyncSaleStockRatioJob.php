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

    public $syncToday;

    /**
     * Create a new job instance.
     */
    public function __construct($syncToday)
    {
        $this->syncToday = $syncToday;
    }

    /**
     * Execute the job.
     */
    public function handle(DashboardRepositoryEloquent $service)
    {
        Log::info('Sync Process Sale Stock Ratio...');
        $upsertSalesStockRatio = $service->syncSaleStockRatio($this->syncToday);
        Log::info('Finish Sync Sale Stock Ratio...');

        // Message queue job has done
        broadcast(new JobCompleted('Sync Sale Stock Ratio has been successed !'));
    }
}
