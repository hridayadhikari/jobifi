<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seeker_profiles', function (Blueprint $table) {
            $table->string('headline')->nullable()->after('user_id');
            $table->string('resume_original_name')->nullable()->after('resume_path');
        });
    }

    public function down(): void
    {
        Schema::table('seeker_profiles', function (Blueprint $table) {
            $table->dropColumn(['headline', 'resume_original_name']);
        });
    }
};
