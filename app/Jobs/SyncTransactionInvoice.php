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

use App\Models\DataWareHouseInvoice;
use App\Services\Repositories\DataWarehouseInvoiceRepositoryEloquent;

class SyncTransactionInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userData;
    public $transactionDateFrom;
    public $transactionDateTo;
    /**
     * Create a new job instance.
     */
    public function __construct($userData, $transactionDateFrom, $transactionDateTo)
    {
        $this->userData = $userData;
        $this->transactionDateFrom = $transactionDateFrom;
        $this->transactionDateTo = $transactionDateTo;
    }

    /**
     * Execute the job.
     */
    public function handle(DataWarehouseInvoiceRepositoryEloquent $service): void
    {
        Log::info('Sync Process Upsert Invoice Transaction...');
        $upsertInvoiceTransaction = $service->getDataWareHouseInvoiceFromJubelio($this->userData, $this->transactionDateFrom, $this->transactionDateTo);
        Log::info('Finish Sync Process Upsert Invoice Transaction...');

        Log::info('Sync Process Upsert Detail Invoice Transaction...');
        $upsertDetailInvoiceTransaction = $service->getDataWarehouseDetailInvoiceFromJUbelio($this->userData, $this->transactionDateFrom, $this->transactionDateTo);
        Log::info('Finish Sync Process Upsert Detail Invoice Transaction...');

        broadcast(new JobCompleted('Sync Transaction Invoice has been successed !'));
    }
}
