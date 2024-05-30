<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('sales-return:sync')->dailyAt('16:00');
        $schedule->command('product:sync')->dailyAt('18:00');
        $schedule->command('vendors:sync')->dailyAt('18:45');
        $schedule->command('purchase-orders:sync')->dailyAt('19:00');
        $schedule->command('purchase-invoice:sync')->dailyAt('19:30');
        $schedule->command('basket-size:sync')->dailyAt('20:00');
        $schedule->command('best_product:sync')->dailyAt('20:30');
        $schedule->command('sales-turn-over-market-place:sync')->dailyAt('21:00');
        $schedule->command('sale-through:sync')->dailyAt('21:30');
        $schedule->command('sale-stock-ratio:sync')->dailyAt('22:00');
        $schedule->command('sales-order:sync')->dailyAt('23:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
