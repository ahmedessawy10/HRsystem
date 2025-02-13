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
        Schema::create('hr_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('discount', 5, 2);
            $table->decimal('overtime', 5, 2);
            $table->time('start_time'); // وقت بدء العمل
            $table->time('end_time'); // وقت انتهاء العمل
            $table->string('day_off_1'); // يوم الإجازة الأول
            $table->string('day_off_2'); // يوم الإجازة الثاني
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
