<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Services\Repositories\ProductRepositoryEloquent;

class SyncProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userData;
    /**
     * Create a new job instance.
     */
    public function __construct( $userData)
    {
        $this->userData = $userData;
    }

    /**
     * Execute the job.
     */
    public function handle(ProductRepositoryEloquent $service)
    {
        Log::info('Sync Process Upsert Product...');
        $upsertProduct = $service->updateProductItem($this->userData);
        Log::info('Finish Sync Process Upsert Product...');

        Log::info('Sync Process Upsert Item Product...');
        $upsertItemProduct = $service->updateItemProduct($this->userData);
        Log::info('Finish Sync Process Upsert Item Product...');

        Log::info('Sync Process Upsert Item Product Bundle...');
        $upsertItemProductBundle = $service->updateItemBundling($this->userData);
        Log::info('Finish Process Upsert Item Product Bundle...');
    }
}
