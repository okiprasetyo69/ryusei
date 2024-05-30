<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Repositories\DashboardRepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SaleThroughSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sale-through:sync';

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
        $this->info('Start sync Sale Through ...');
        Log::info("Start sync Sell Through ...");
        $syncSellThrough = $service->syncSellThrough();
        Log::info("Finsi sync Sale Through ...");
        $this->info('Finish sync Sale Through ...');
    }
}
