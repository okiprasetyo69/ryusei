<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Repositories\DashboardRepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SaleStockRatioSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sale-stock-ratio:sync';

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
        $this->info('Start sync Sale Stock Ratio ...');
        Log::info("Start sync Sell Stock Ratio ...");
        $syncSaleStockRatio =  $service->syncSaleStockRatio();
        Log::info("End sync Sell Stock Ratio ...");
        $this->info('Start sync Sale Stock Ratio ...');
    }
}
