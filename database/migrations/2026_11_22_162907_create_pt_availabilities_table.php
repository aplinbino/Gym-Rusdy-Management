<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pt_availabilities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pt_profile_id')
                ->constrained('pt_profiles')
                ->cascadeOnDelete();

            $table->dateTime('start_at');
            $table->dateTime('end_at');

            $table->enum('status', [
                'available',
                'booked',
                'inactive'
            ])->default('available');

            $table->timestamps();

            $table->index([
                'pt_profile_id',
                'start_at',
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pt_availabilities');
    }
};
