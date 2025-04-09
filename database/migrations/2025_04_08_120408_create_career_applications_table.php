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
        Schema::create('career_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId("career_id")->constrained("careers")->onDelete("cascade");
            $table->string("name");
            $table->string("email");
            $table->string("cv");
            $table->string("phone");
            $table->string("cover_letter")->nullable();
            $table->string("status")->default("pending");
            $table->string("ai_rate")->nullable();
            $table->string("ai_summary")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};
