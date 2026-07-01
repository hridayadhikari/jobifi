<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seeker_languages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_profile_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('language');
            $table->enum('proficiency', ['native', 'fluent', 'professional', 'basic'])
                  ->default('basic');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seeker_languages');
    }
};
