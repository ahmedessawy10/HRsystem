<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cv_analyses', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('cv_analyses', 'summary')) {
                $table->text('summary')->nullable();
            }
            if (!Schema::hasColumn('cv_analyses', 'soft_skills')) {
                $table->integer('soft_skills')->default(0);
            }
            if (!Schema::hasColumn('cv_analyses', 'relevant_experience')) {
                $table->integer('relevant_experience')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('cv_analyses', function (Blueprint $table) {
            $table->dropColumn(['summary', 'soft_skills', 'relevant_experience']);
        });
    }
};