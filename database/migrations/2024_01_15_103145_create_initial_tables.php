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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id')->change();
        });

        Schema::create('speech_parts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('text');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('words', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('text')->unique();
            $table->string('transcription_american');
            $table->string('transcription_british');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('word_id')->index()->constrained('words')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('speech_part_id')->nullable()->constrained('speech_parts')->nullOnDelete()->nullOnUpdate();
            $table->string('text');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('user_word_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->index()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('word_id')->index()->constrained('words')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['user_id', 'word_id']);
            $table->timestamps();
        });

        Schema::create('examples', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('word_id')->index()->constrained('words')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('text_ru');
            $table->string('text_en');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examples');
        Schema::dropIfExists('user_word_pivot');
        Schema::dropIfExists('translations');
        Schema::dropIfExists('words');
        Schema::dropIfExists('speech_parts');

        Schema::table('users', function (Blueprint $table) {
            $table->integer('id')->change();
        });
    }
};
