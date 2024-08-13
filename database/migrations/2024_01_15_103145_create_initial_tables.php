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
        Schema::create('speech_parts', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('text');
            $table->string('transcription')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->index()->constrained('words')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('speech_part_id')->nullable()->constrained('speech_parts')->nullOnDelete()->nullOnUpdate();
            $table->string('text');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('examples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_id')->index()->constrained('words')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('translations');
        Schema::dropIfExists('words');
        Schema::dropIfExists('speech_parts');
    }
};
