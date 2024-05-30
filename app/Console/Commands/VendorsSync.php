<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Repositories\VendorRepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class VendorsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vendors:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(VendorRepositoryEloquent $service)
    {
        $userData = User::where("email", "superadmin@test.com")->first();

        $this->info('Start sync Upsert Vendor ... ');
        Log::info("Start sync Upsert Vendor ...");
        $upsertVendor = $service->getSupplierFromJubelio($userData);    
        Log::info("Finsh sync Upsert Vendor ...");
        $this->info('Finsh sync Upsert Vendor ... ');
    }
}
