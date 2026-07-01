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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('industry')->nullable()->after('headquarters_location');
            $table->unsignedSmallInteger('founded_year')->nullable()->after('industry');
            $table->string('employee_count')->nullable()->after('founded_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['industry', 'founded_year', 'employee_count']);
        });
    }
};
