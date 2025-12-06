<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_translations', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('language_code', 8);
            $table->string('field');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['model_type', 'model_id', 'language_code', 'field'], 'content_translation_unique');
            $table->foreign('language_code')->references('code')->on('languages')->cascadeOnDelete();
            $table->index(['model_id', 'model_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_translations');
    }
};
