<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'customer_cars', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( 'customer_id' )->constrained()->cascadeOnDelete();
            $table->foreignId( 'car_brand_id' )->constrained( 'car_brands' );
            $table->foreignId( 'car_model_id' )->constrained( 'car_models' );

            $table->string( 'vin' )->nullable();
            $table->string( 'registration_no' )->nullable();
            $table->integer( 'odometer' )->nullable();

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'customer_cars' );
    }
};
