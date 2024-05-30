<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Repositories\ProductRepositoryEloquent;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProductSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ProductRepositoryEloquent $service)
    {
        $userData = User::where("email", "superadmin@test.com")->first();

        $this->info('Start sync Upsert Product ... ');
        Log::info("Start sync Upsert Product ...");
        $upsertProduct = $service->updateProductItem($userData);
        Log::info("Finsh sync Upsert Product ...");
        $this->info('Finsh sync Upsert Product ... ');

        $this->info('Start sync Upsert Item Product ... ');
        Log::info("Start sync Upsert Item Product ...");
        $upsertItemProduct =  $service->updateItemProduct($userData);
        Log::info("Finish sync Upsert Item Product");
        $this->info('Finish sync Upsert Item Product ... ');

        $this->info('Start sync Upsert Item Bundling ... ');
        Log::info("Start sync Upsert Item Bundling");
        $upsertItemBundling = $service->updateItemBundling($userData);
        Log::info("Finish sync Upsert Item Bundling");
        $this->info('Finish sync Upsert Item Bundling ... ');
    }
}
