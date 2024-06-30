<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::create('product_details', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('code')->unique();
        //     $table->foreignId('product_id')->constrained();
        //     $table->integer('buying_price');
        //     $table->integer('selling_price');
        //     $table->boolean('is_active')->default(true);
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
