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
    Schema::create('employees', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('image_url')->nullable();
        $table->string('email')->unique();
        $table->string('contact_number');
        $table->decimal('salary', 10, 2);
        $table->string('address');
        $table->date('dob');
        $table->integer('age');
        $table->timestamps();
        $table->string('national_id')->unique()->nullable();
        $table->time('attendance_time')->nullable();
        $table->string('role')->nullable();
        $table->enum('marital_status', ['single', 'married'])->default('single');
        $table->enum('gender', ['male', 'female'])->default('male');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['national_id', 'attendance_time', 'role', 'marital_status', 'gender']);
        });
        Schema::dropIfExists('employees');
    }
};
