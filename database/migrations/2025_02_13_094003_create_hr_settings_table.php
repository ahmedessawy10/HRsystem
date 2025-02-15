<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('hr_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('overtime', 8, 2)->default(0);
            $table->decimal('discount', 8, 2)->default(0);
            $table->time('start_time')->nullable()->default('00:00:00');
            $table->time('end_time');
            $table->string('day_off_1');
            $table->string('day_off_2')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_settings');
    }
};
