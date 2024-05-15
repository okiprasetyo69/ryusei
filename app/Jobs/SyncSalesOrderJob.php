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
use App\Events\QueueJobCompleted;

use App\Services\Repositories\DataWarehouseSalesOrderRepositoryEloquent;

class SyncSalesOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userData;
    public $transactionDateFrom;
    public $transactionDateTo;
    /**
     * Create a new job instance.
     */
    public function __construct( $userData, $transactionDateFrom, $transactionDateTo)
    {
        $this->userData = $userData;
        $this->transactionDateFrom = $transactionDateFrom;
        $this->transactionDateTo = $transactionDateTo;
    }

    /**
     * Execute the job.
     */
    public function handle(DataWarehouseSalesOrderRepositoryEloquent $service): void
    {
        Log::info('Sync Process Upsert Sales Order...');
        $upsertPurchaseInvoice = $service->getDataWareHouseOrderFromJubelio($this->userData, $this->transactionDateFrom, $this->transactionDateTo);
        Log::info('Finish Sync Process Sales Order...');

        Log::info('Sync Process Upsert Detail Sales Order...');
        $upsertPurchaseDetailInvoice = $service->getDataWareHouseDetailOrderTransaction($this->userData, $this->transactionDateFrom, $this->transactionDateTo);
        Log::info('Finish Sync Process Upsert Sales Order...');
    }
}
