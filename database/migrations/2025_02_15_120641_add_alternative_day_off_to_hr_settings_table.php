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
    Schema::table('hr_settings', function (Blueprint $table) {
        $table->string('alternative_day_off')->nullable()->after('day_off_2');
    });
}

public function down()
{
    Schema::table('hr_settings', function (Blueprint $table) {
        $table->dropColumn('alternative_day_off');
    });
}

};
