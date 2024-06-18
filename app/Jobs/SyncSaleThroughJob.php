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

class SyncSaleThroughJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $endDate;
    public $startDate;
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
        Log::info('Sync Process Upsert Sell Through ...');
        $upsertSaleThrough = $service->syncSellThrough($this->startDate, $this->endDate);
        Log::info('Finish Sync Sell Through...');

        // Message queue job has done
        broadcast(new JobCompleted('Sync Sell Through has been successed !'));
    }
}
