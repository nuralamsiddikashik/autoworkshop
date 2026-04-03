<?php

use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CarReceiveController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JobCardController;
use Illuminate\Support\Facades\Route;

Route::get( '/', [DashboardController::class, 'index'] )->name( 'dashboard' );

Route::prefix( 'customers' )->name( 'customers.' )->group( function () {

    Route::get( '/', [CustomerController::class, 'index'] )->name( 'index' );
    Route::post( '/store', [CustomerController::class, 'store'] )->name( 'store' );

    Route::get( '/edit/{id}', [CustomerController::class, 'edit'] )->name( 'edit' );
    Route::put( '/update/{id}', [CustomerController::class, 'update'] )->name( 'update' );

    Route::delete( '/delete/{id}', [CustomerController::class, 'destroy'] )->name( 'delete' );

} );

Route::prefix( 'cars' )->name( 'cars.' )->group( function () {

    Route::controller( CarBrandController::class )
        ->prefix( 'brands' )
        ->name( 'brands.' )
        ->group( function () {

            Route::get( '/', 'index' )->name( 'index' );
            Route::post( '/', 'store' )->name( 'store' );
            Route::put( '/{id}', 'update' )->name( 'update' );
            Route::delete( '/{id}', 'destroy' )->name( 'destroy' );

        } );

    Route::controller( CarModelController::class )
        ->prefix( 'models' )
        ->name( 'models.' )
        ->group( function () {

            Route::get( '/', 'index' )->name( 'index' );
            Route::post( '/', 'store' )->name( 'store' );
            Route::put( '/{id}', 'update' )->name( 'update' );
            Route::delete( '/{id}', 'destroy' )->name( 'destroy' );

        } );

} );

Route::prefix( 'car-receives' )->name( 'car-receives.' )->group( function () {

    Route::controller( CarReceiveController::class )->group( function () {

        // ================= MAIN =================
        Route::get( '/index', 'index' )->name( 'index' );
        Route::get( '/create', 'create' )->name( 'create' );
        Route::post( '/store', 'store' )->name( 'store' );

        // ================= AJAX =================
        Route::get( '/customer/{id}', 'getCustomer' )->name( 'customer' );
        Route::get( '/customer-car', 'getCustomerCar' )->name( 'customer-car' );
        Route::get( '/find-by-registration', 'findByRegistration' )
            ->name( 'car-receives.find-by-registration' );

    } );
} );

Route::prefix( 'job-cards' )->name( 'job-cards.' )->group( function () {

    Route::controller( JobCardController::class )->group( function () {

        // ================= MAIN =================

        Route::get( '/create', 'create' )->name( 'create' );
        Route::post( '/store', 'store' )->name( 'store' );

        // ================= AJAX =================
        Route::get( '/find-receive', 'find' )
            ->name( 'job-cards.find' );

    } );
} );

Route::prefix( 'invoices' )->name( 'invoices.' )->controller( InvoiceController::class )
    ->group( function () {

        // Create Page
        Route::get( '/create', 'create' )->name( 'create' );

        // Store
        Route::post( '/store', 'store' )->name( 'store' );

        // Edit Page
        Route::get( '/edit/{id}', 'edit' )->name( 'edit' );
        Route::put( '/update/{id}', 'update' )->name( 'update' );

        // Delete
        Route::delete( '/delete/{id}', 'destroy' )->name( 'delete' );

        // 🔥 Job No Auto Fetch
        Route::get( '/find-job', 'find' )->name( 'find' );

        Route::get( '/', 'index' )->name( 'index' );
        Route::get( '/show/{id}', 'show' )->name( 'show' );
        Route::get( '/pdf/{id}', 'pdf' )
            ->name( 'pdf' );
    } );
