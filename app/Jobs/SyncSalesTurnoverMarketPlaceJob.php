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

class SyncSalesTurnoverMarketPlaceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userData;
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
       //
    }

    /**
     * Execute the job.
     */
    public function handle(DashboardRepositoryEloquent $service)
    {
        Log::info('Sync Process Upsert Sales Turnover from marketplace...');
        $upsertSalesTurnoverMarketPlace = $service->syncSalesTurnOver();
        Log::info('Finish Sync Sales Turnover from marketplace...');

        // Message queue job has done
        broadcast(new JobCompleted('Sync Sales Turnover from marketplace has been successed !'));
    }
}
