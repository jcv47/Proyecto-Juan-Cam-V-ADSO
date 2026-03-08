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
        Schema::create('ai_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('submission_id')->unique()
                ->constrained('submissions')
                ->cascadeOnDelete();

            $table->enum('sentiment', ['positivo', 'neutral', 'negativo'])->nullable();
            $table->enum('severity', ['bueno', 'regular', 'critico'])->nullable();

            $table->text('summary')->nullable();
            $table->json('improvements')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_reports');
    }
};
