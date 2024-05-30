<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Services\Repositories\PurchasingInvoiceRepositoryEloquent;

class PurchaseInvoiceSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase-invoice:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(PurchasingInvoiceRepositoryEloquent $service)
    {
        $userData = User::where("email", "superadmin@test.com")->first();

        $this->info('Start sync Upsert Purchase Invoice ... ');
        Log::info("Start sync Upsert Purchase Invoice ...");
        $upsertPurchaseInvoice = $service->getPurchaseInvoiceFromJubelio($userData);
        Log::info("Finsh sync Upsert Purchase Invoice ...");
        $this->info('Finsh sync Upsert Purchase Invoice ... ');

        $this->info('Start sync Upsert Detail Item Purchase Invoice ... ');
        Log::info("Start sync Upsert Detail Item Purchase Invoice ...");
        $upsertPurchaseDetailInvoice = $service->detailPurchaseInvoice($userData);
        Log::info("Finsh sync Upsert  Detail Item Purchase Invoice ...");
        $this->info('Finsh sync Upsert Detail Item Purchase Invoice ... ');
    }
}
