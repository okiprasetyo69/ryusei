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

class SyncBasketSizeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        Log::info('Sync Process Basket Size...');
        $upsertBasketSize= $service->syncBasketSize();
        Log::info('Finish Sync Basket Size...');

        // Message queue job has done
        broadcast(new JobCompleted('Sync Basket Size has been successed !'));
    }
}
