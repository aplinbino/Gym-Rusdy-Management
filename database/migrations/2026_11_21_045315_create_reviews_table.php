<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Member yang memberikan ulasan
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Target ulasan: gym atau PT
            $table->enum('target_type', ['gym', 'pt']);
            $table->unsignedBigInteger('target_id');

            // Penilaian
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();

            $table->timestamps();

            // Satu member hanya punya satu ulasan
            // untuk setiap target, tetapi bisa memperbaruinya
            $table->unique(
                ['user_id', 'target_type', 'target_id'],
                'reviews_user_target_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
