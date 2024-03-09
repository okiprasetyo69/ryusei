<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

use App\Services\Interfaces\UserService;
use App\Services\Interfaces\RoleService;
use App\Services\Interfaces\CategoryService;

use App\Services\Repositories\UserRepositoryEloquent;
use App\Services\Repositories\RoleRepositoryEloquent;
use App\Services\Repositories\CategoryRepositoryEloquent;


class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * List of all of the container singletons.
     * This properties will inject the key class into value class.
     * Ex. AuthService class will injected into AuthRepository class.
     * 
     */
    public $singletons = [
        UserService::class => UserRepositoryEloquent::class,
        RoleService::class => RoleRepositoryEloquent::class,
        CategoryService::class => CategoryRepositoryEloquent::class,
    ];

    /**
     * @author  Oki Prasetyo <oki.prasetyo45@gmail.com>
     * @since   08 March 2024
     * 
     * Get the services provided by the provider.
     * Return the service container binding.
     * 
     * @return array<int, string>
     */
    public function provides() : array
    {
        return [
            UserService::class,
            RoleService::class,
            CategoryService::class,
        ];
    }


    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
