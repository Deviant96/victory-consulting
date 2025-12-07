<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('translation_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('translation_key_id')->constrained('translation_keys')->cascadeOnDelete();
            $table->string('language_code', 10);
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['translation_key_id', 'language_code']);
            $table->index('language_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('translation_values');
    }
};
