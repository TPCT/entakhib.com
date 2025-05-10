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
        Schema::table('profile_votes', function (Blueprint $table) {
            $table->unsignedBigInteger('city_id')->after('cluster_id')->nullable();
            $table->unsignedBigInteger('district_id')->after('city_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_votes', function (Blueprint $table) {
            //
        });
    }
};
