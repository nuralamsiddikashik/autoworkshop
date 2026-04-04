<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'invoices', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( 'job_card_id' )->constrained()->cascadeOnDelete();

            $table->decimal( 'parts_total', 10, 2 )->default( 0 );
            $table->decimal( 'works_total', 10, 2 )->default( 0 );
            $table->decimal( 'service_total', 10, 2 )->default( 0 );

            $table->decimal( 'grand_total', 10, 2 );
            $table->decimal( 'vat', 10, 2 );
            $table->decimal( 'bill_amount', 10, 2 );
            $table->decimal( 'total_profit', 10, 2 )->default( 0 );
            $table->decimal( 'paid_amount', 12, 2 )->default( 0 );
            $table->decimal( 'due_amount', 12, 2 )->default( 0 );
            $table->enum( 'status', ['unpaid', 'partial', 'paid'] )
                ->default( 'unpaid' );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'invoices' );
    }
};
