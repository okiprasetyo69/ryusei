<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Repositories\PurchaseOrderRepositoryEloquent;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PurchaseOrdersSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase-orders:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(PurchaseOrderRepositoryEloquent $service)
    {
        $userData = User::where("email", "superadmin@test.com")->first();

        $this->info('Start sync Upsert Purchase Order ... ');
        Log::info("Start sync Upsert Purchase Order ...");
        $upsertPurchaseOrder = $service->updatePurchaseOrderSync($userData);
        Log::info("Finish sync Upsert Purchase Order ...");
        $this->info('Finish sync Upsert Purchase Order ... ');

        $this->info('Start sync Upsert Detail Purchase Order ... ');
        Log::info('Start sync Upsert Detail Purchase Order ...');
        $upsertDetailPurchaseOrder = $service->updateDetailPurchaseOrderSync($userData);
        Log::info('Finish sync Upsert Detail Purchase Order ...');
        $this->info('Finish sync Upsert Detail Purchase Order ... ');
    }
}
