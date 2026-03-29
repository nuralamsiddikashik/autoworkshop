<?php

use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
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