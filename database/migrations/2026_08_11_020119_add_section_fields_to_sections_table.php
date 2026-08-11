<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('adviser')->after('name');
            $table->string('year_level')->after('adviser');
            $table->string('school_year')->after('year_level');
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'adviser',
                'year_level',
                'school_year',
            ]);
        });
    }
};