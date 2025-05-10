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
        Schema::create('clusters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\City\City::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\District\District::class)->constrained()->cascadeOnDelete();
            $table->string('slug')->nullable(false);
            $table->unsignedMediumInteger('weight')->nullable(false)->default(0);
            $table->boolean('status')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('clusters_lang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->index()->references('id')->on('clusters')->cascadeOnDelete();
            $table->string('language', 10)->index()->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('second_title')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('thumbnail_image_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->unsignedBigInteger('header_image_id')->nullable();
            $table->string('header_image_title')->nullable();
            $table->string('header_image_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clusters_lang');
        Schema::dropIfExists('clusters');
    }
};
