<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'invoice_items', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( 'invoice_id' )->constrained()->cascadeOnDelete();

            $table->string( 'type' ); // part | work | service

            $table->string( 'name' );
            $table->decimal( 'buy_price', 10, 2 )->nullable();
            $table->integer( 'qty' )->default( 1 );
            $table->string( 'unit' )->nullable();

            $table->decimal( 'unit_price', 10, 2 )->nullable();
            $table->decimal( 'sell_price', 10, 2 );

            $table->decimal( 'total', 10, 2 );
            $table->decimal( 'profit', 10, 2 );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'invoice_items' );
    }
};
