
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_latihan', function (Blueprint $table) {
            $table->id();

            // Member pemilik jadwal
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // PT yang membimbing (NULL jika latihan mandiri)
            $table->foreignId('pt_id')
                  ->nullable()
                  ->constrained('pt')
                  ->nullOnDelete();

            // Transaksi pembelian sesi PT
            $table->foreignId('transaksi_id')
                  ->nullable()
                  ->constrained('transaksi')
                  ->nullOnDelete();

            // Detail jadwal
            $table->date('tanggal');
            $table->time('jam');
            $table->string('jenis_latihan', 50);

            // Status jadwal
            $table->enum('status', [
                'scheduled',
                'pending',
                'approved',
                'completed',
                'cancelled'
            ])->default('scheduled');

            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_latihan');
    }
};
