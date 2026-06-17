<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Moves designation, phone, linkedin_url from recruiter_profiles → users
     * then drops the recruiter_profiles table.
     */
    public function up(): void
    {
        // 1. Add recruiter fields directly to the users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('designation')->nullable()->after('profile_photo');
            $table->string('phone')->nullable()->after('designation');
            $table->string('linkedin_url')->nullable()->after('phone');
        });

        // 2. Migrate existing data from recruiter_profiles → users
        if (Schema::hasTable('recruiter_profiles')) {
            DB::table('recruiter_profiles')->get()->each(function ($profile) {
                DB::table('users')->where('id', $profile->user_id)->update([
                    'designation' => $profile->designation,
                    'phone'       => $profile->phone,
                    'linkedin_url'=> $profile->linkedin_url,
                ]);
            });

            // 3. Drop the now-redundant table
            Schema::dropIfExists('recruiter_profiles');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate recruiter_profiles
        Schema::create('recruiter_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('designation');
            $table->string('phone');
            $table->string('linkedin_url')->nullable();
            $table->timestamps();
        });

        // Remove columns from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['designation', 'phone', 'linkedin_url']);
        });
    }
};
