<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Log;
use App\Events\JobCompleted;

use App\Models\Vendor;
use App\Services\Repositories\VendorRepositoryEloquent;

class SyncVendorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userData;

    /**
     * Create a new job instance.
     */
    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Execute the job.
     */
    public function handle(VendorRepositoryEloquent $service): void
    {
        Log::info('Sync Process Upsert Vendors or Suppliers...');
        $upsertVendor = $service->getSupplierFromJubelio($this->userData);
        Log::info('Finish Sync Process Upsert Vendors or Suppliers...');

        broadcast(new JobCompleted('Sync Vendor or Supplier has been successed !'));
    }
}
