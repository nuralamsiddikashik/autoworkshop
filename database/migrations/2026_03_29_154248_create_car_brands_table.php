<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create( 'car_brands', function ( Blueprint $table ) {
            $table->id();

            $table->string( 'name' )->unique(); // unique brand name
            $table->string( 'slug' )->nullable()->unique(); // optional slug

            $table->boolean( 'is_active' )->default( true );

            $table->timestamps();
            $table->softDeletes(); // optional (pro feature)
        } );
    }

    public function down(): void {
        Schema::dropIfExists( 'car_brands' );
    }
};
