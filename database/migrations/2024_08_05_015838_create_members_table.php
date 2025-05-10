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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->index()->constrained()->cascadeOnDelete();
            $table->string('member_type')->nullable(false);
            $table->unsignedBigInteger('party_id')->index()->unsigned()->nullable();
            $table->unsignedBigInteger('cluster_id')->index()->unsigned()->nullable();
            $table->unsignedBigInteger('image_id')->index()->unsigned()->nullable();
            $table->unsignedBigInteger('votes')->default(0);
            $table->string('phone_1')->default(null)->nullable();
            $table->string('phone_2')->default(null)->nullable();
            $table->string('facebook_link')->default(null)->nullable();
            $table->string('instagram_link')->default(null)->nullable();
            $table->string('twitter_link')->default(null)->nullable();
            $table->string('youtube_link')->default(null)->nullable();
            $table->float('election_location_longitude')->nullable();
            $table->float('election_location_latitude')->nullable();
            $table->string('video_url')->nullable();
            $table->string('slug');
            $table->unsignedMediumInteger('weight')->nullable(false)->default(0);
            $table->boolean('status')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('members_lang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->index()->references('id')->on('members')->cascadeOnDelete();
            $table->string('language', 10)->nullable(false);
            $table->string('title')->nullable(false);
            $table->string('slogan')->nullable();
            $table->string('election_program_description')->nullable();
            $table->unsignedBigInteger('election_program_link_id')->nullable();
            $table->string('description')->nullable();
            $table->string('election_location_description')->nullable();
        });

        Schema::create('member_images', function (Blueprint $table) {
            $table->foreignId('parent_id')->index()->references('id')->on('members')->cascadeOnDelete();
            $table->foreignIdFor(\Awcodes\Curator\Models\Media::class)->index()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members_lang');
        Schema::dropIfExists('members_images');
        Schema::dropIfExists('members');
    }
};
