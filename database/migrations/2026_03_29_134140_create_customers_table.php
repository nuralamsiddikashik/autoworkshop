<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'customers', function ( Blueprint $table ) {
            $table->id();

            $table->string( 'account_name' )->index();
            $table->string( 'customer_name' )->index();

            $table->text( 'address' )->nullable();

            $table->string( 'owner_phone', 20 )->index();
            $table->string( 'transport_phone', 20 )->nullable();
            $table->string( 'driver_phone', 20 )->nullable();
            $table->string( 'office_phone', 20 )->nullable();

            $table->boolean( 'is_active' )->default( true )->index();

            $table->timestamps();
            $table->softDeletes();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'customers' );
    }
};
