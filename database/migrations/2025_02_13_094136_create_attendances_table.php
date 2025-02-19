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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->time('time_in')->nullable();  // Allow NULL values
            $table->time('time_out')->nullable(); // Allow NULL values
            $table->date('date');
            $table->foreignId('user_id')->constrained('users');
            $table->integer('late_minutes')->default(0);
            $table->integer('extra_minutes')->default(0);
            $table->unique(['user_id', 'date'], 'user_id_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
