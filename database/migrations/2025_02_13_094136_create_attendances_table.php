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
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->date('date');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('late_hours', 8, 2)->nullable()->default(0.0);
            $table->decimal('extra_hours', 8, 2)->nullable()->default(0.0);
            $table->string('work_from')->default("company");
            $table->decimal('longitude', 10, 8)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
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
