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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->decimal('amount', 8, 2);
            $table->string('currency', 3);
            $table->string('callbackUrl')->nullable();
            $table->string('phone');
            $table->foreignId('eleve_id')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('frais_id'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
