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

use App\Models\PurchaseInvoice;
use App\Services\Repositories\PurchasingInvoiceRepositoryEloquent;

class SyncPurchaseInvoiceJob implements ShouldQueue
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
    public function handle(PurchasingInvoiceRepositoryEloquent $service): void
    {
        Log::info('Sync Process Upsert Purchase Invoice...');
        $upsertPurchaseInvoice = $service->getPurchaseInvoiceFromJubelio($this->userData);
        Log::info('Finish Sync Process Purchase Invoice...');

        Log::info('Sync Process Upsert Detail Purchase Invoice...');
        $upsertPurchaseDetailInvoice = $service->detailPurchaseInvoice($this->userData);
        Log::info('Finish Sync Process Upsert Detail Purchase Invoice...');

        broadcast(new JobCompleted('Sync Invoice Transaction has been successed !'));
    }
}
