<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Repositories\DashboardRepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class BestProductSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'best-product:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(DashboardRepositoryEloquent $service)
    {
        $this->info('Start sync Upsert Best Product ...');
        Log::info("Start sync Upsert Best Product ...");
        $syncBestProduct = $service->syncBestProduct();
        $this->info('Finish sync Upsert Best Product ...');
        Log::info("Finish sync Upsert Best Producte ...");
    }
}
