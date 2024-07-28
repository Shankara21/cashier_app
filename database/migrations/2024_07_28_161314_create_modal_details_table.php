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
        Schema::create('modal_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modal_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->integer('amount');
            $table->enum('type', ['income', 'expense']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modal_details');
    }
};
