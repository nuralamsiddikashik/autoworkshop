<?php

namespace App\Providers;

use App\Repositories\Contracts\CarBrandRepositoryInterface;
use App\Repositories\Contracts\CarModelRepositoryInterface;
use App\Repositories\Contracts\CarReceiveRepositoryInterface;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Repositories\Contracts\JobCardRepositoryInterface;
use App\Repositories\Contracts\MoneyReceiptRepositoryInterface;
use App\Repositories\Eloquent\CarBrandRepository;
use App\Repositories\Eloquent\CarModelRepository;
use App\Repositories\Eloquent\CarReceiveRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\InvoiceRepository;
use App\Repositories\Eloquent\JobCardRepository;
use App\Repositories\Eloquent\MoneyReceiptRepository;
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
        $this->app->bind( JobCardRepositoryInterface::class, JobCardRepository::class );
        $this->app->bind(
            InvoiceRepositoryInterface::class,
            InvoiceRepository::class
        );
        $this->app->bind(
            MoneyReceiptRepositoryInterface::class,
            MoneyReceiptRepository::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
