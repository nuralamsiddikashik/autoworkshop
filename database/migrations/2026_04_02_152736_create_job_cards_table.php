<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'job_cards', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( 'car_receive_id' )->constrained()->cascadeOnDelete();

            $table->string( 'job_no' )->unique();
            $table->text( 'problem_note' )->nullable();
            $table->text( 'work_note' )->nullable();

            $table->enum( 'status', ['pending', 'in_progress', 'done'] )->default( 'pending' );

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'job_cards' );
    }
};
