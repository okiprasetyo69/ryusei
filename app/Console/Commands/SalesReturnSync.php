<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Repositories\SalesReturnRepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SalesReturnSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales-return:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(SalesReturnRepositoryEloquent $service)
    {
        $userData = User::where("email", "superadmin@test.com")->first();

        $timestamp = strtotime('-7 days');
        $startDate = date('Y-m-d', $timestamp);
        $endDate =  date('Y-m-d');

        $this->info('Start sync upsert Sales Return ... ');
        Log::info("Start sync Upsert Sales Return ...");
        $upsertSalesReturn = $service->getSalesReturnFromJubelio($userData, $startDate, $endDate);
        Log::info("Finish sync Upsert Sales Return ...");
        $this->info('Finish sync Upsert Sales Return ... ');

        $this->info('Start sync upsert Detail Sales Return ... ');
        Log::info("Start sync Upsert Detail Sales Return ...");
        $upsertDetailItemSalesReturn = $service->getDetailSalesReturnFromJubelio($userData, $startDate, $endDate);
        Log::info("Finish sync Upsert Detail Sales Return ...");
        $this->info('Finish sync Upsert Detail Sales Return ... ');
    }
}
