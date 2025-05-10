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
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropForeign('members_city_id_foreign');
            $table->dropForeign('members_district_id_foreign');
            $table->dropIndex('members_city_id_index');
            $table->dropIndex('members_district_id_index');
            $table->dropColumn('city_id');
            $table->dropColumn('district_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidates', function (Blueprint $table) {
            //
        });
    }
};
