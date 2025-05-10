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
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('place_of_residence');
            $table->dropColumn('district');
            $table->foreignIdFor(\App\Models\City\City::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\District\District::class)->index()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
