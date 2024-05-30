<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncSalesOrderJob;
use App\Services\Repositories\DashboardRepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SalesOrderSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales-order:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userData = User::where("email", "superadmin@test.com")->first();
        $timestamp = strtotime('-7 days');
        $startDate = date('Y-m-d', $timestamp);
        $endDate =  date('Y-m-d');

        $this->info('Start sync Sales Order On Queue ...');
        Log::info("Start sync Sales Order On Queue ...");
        
        // Run Queue
        SyncSalesOrderJob::dispatch($userData, $startDate, $endDate);

        Log::info("Finish sync Sales Order On Queue ...");
        $this->info('Finish sync Sales Order On Queue ...');
    }
}
