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
        Schema::table('seeker_profiles', function (Blueprint $table) {

    $table->string('cover_photo')->nullable();

    $table->string('resume_path')->nullable();

    $table->string('linkedin_url')->nullable();

    $table->string('github_url')->nullable();

    $table->string('portfolio_url')->nullable();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seeker_profiles', function (Blueprint $table) {
            //
        });
    }
};
