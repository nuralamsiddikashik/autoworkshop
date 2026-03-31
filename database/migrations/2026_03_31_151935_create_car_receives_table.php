<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'car_receives', function ( Blueprint $table ) {
            $table->id();

            $table->string( 'receive_no' )->unique();

            $table->foreignId( 'customer_id' )->constrained();
            $table->foreignId( 'customer_car_id' )->constrained( 'customer_cars' );

            $table->integer( 'odometer' )->nullable();
            $table->text( 'note' )->nullable();

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'car_receives' );
    }
};
