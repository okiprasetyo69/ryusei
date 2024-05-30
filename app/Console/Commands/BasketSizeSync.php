<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncBasketSizeJob;
use App\Services\Repositories\DashboardRepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class BasketSizeSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'basket-size:sync';

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
        $this->info('Start sync Upser Basket Size ... ');
        Log::info("Start sync Upsert Basket Size ...");
        $syncBasketSize = $service->syncBasketSize();
        Log::info("Finish sync Upsert Basket Size ...");
        $this->info('Finish sync Basket Size ... ');
    }
}
