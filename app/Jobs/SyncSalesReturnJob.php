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

use App\Services\Repositories\SalesReturnRepositoryEloquent;

class SyncSalesReturnJob implements ShouldQueue
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
    public function handle(SalesReturnRepositoryEloquent $service): void
    {
        Log::info('Sync Process Upsert Sales Return...');
        $upsertSalesReturn = $service->getSalesReturnFromJubelio($this->userData, $this->transactionDateFrom, $this->transactionDateTo);
        Log::info('Finish Sync Process Sales Return...');

        Log::info('Sync Process Upsert Detail Sales Return...');
        $upsertSalesReturnDetail = $service->getDetailSalesReturnFromJubelio($this->userData, $this->transactionDateFrom, $this->transactionDateTo);
        Log::info('Finish Sync Process Upsert Sales Return...');

        broadcast(new JobCompleted('Sync Sales Return Completed has been successed !'));
    }
}
