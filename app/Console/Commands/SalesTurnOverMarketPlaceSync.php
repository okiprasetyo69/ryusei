<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Repositories\DashboardRepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SalesTurnOverMarketPlaceSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales-turn-over-market-place:sync';

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
        $this->info('Start sync omset per market palce ...');
        Log::info("Start sync omset per market palce ...");
        $syncSalesTurnOverMarkerPlace = $service->syncSalesTurnOver();
        Log::info("Start syncomset per market palce ...");
        $this->info('Finish sync omset per market palce ...');
    }
}
