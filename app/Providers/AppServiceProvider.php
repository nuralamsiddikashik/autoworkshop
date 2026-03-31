<?php

namespace App\Providers;

use App\Repositories\Contracts\CarBrandRepositoryInterface;
use App\Repositories\Contracts\CarModelRepositoryInterface;
use App\Repositories\Contracts\CarReceiveRepositoryInterface;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Eloquent\CarBrandRepository;
use App\Repositories\Eloquent\CarModelRepository;
use App\Repositories\Eloquent\CarReceiveRepository;
use App\Repositories\Eloquent\CustomerRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind( CustomerRepositoryInterface::class, CustomerRepository::class );
        $this->app->bind( CarBrandRepositoryInterface::class, CarBrandRepository::class );
        $this->app->bind( CarModelRepositoryInterface::class, CarModelRepository::class );
        $this->app->bind( CarReceiveRepositoryInterface::class, CarReceiveRepository::class );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
