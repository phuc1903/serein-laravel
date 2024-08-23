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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->nullable();
            $table->enum('discount_type', ['percent', 'amount'])->nullable();
            $table->decimal('discount_value', 10, 2)->nullable();
            $table->integer('discount_max')->nullable(); 
            $table->integer('quantity')->default(50);
            $table->integer('user_count')->nullable();
            $table->timestamp('day_start')->nullable();
            $table->timestamp('day_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
