<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Log;
use App\Events\JobCompleted;

use App\Services\Repositories\PurchaseOrderRepositoryEloquent;

class SycnPurchaseOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userData;
    /**
     * Create a new job instance.
     */
    public function __construct( $userData)
    {
        $this->userData = $userData;
    }

    /**
     * Execute the job.
     */
    public function handle(PurchaseOrderRepositoryEloquent $service): void
    {
        Log::info('Sync Process Upsert Purchase Order...');
        $upsertPurchaseOrder = $service->updatePurchaseOrderSync($this->userData);
        Log::info('Finish Sync Process Upsert Purchase Order...');

        Log::info('Sync Process Upsert Detail Purchase Order...');
        $upsertDetailPurchaseOrder = $service->updateDetailPurchaseOrderSync($this->userData);
        Log::info('Finish Sync Process Upsert Detail Purchase Order...');

        broadcast(new JobCompleted('Sync Purchase Order has been successed !'));
    }
}
