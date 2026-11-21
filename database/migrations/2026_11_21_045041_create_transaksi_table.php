
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();

            // Member yang melakukan transaksi
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // PT yang dipilih (khusus transaksi PT)
            $table->foreignId('pt_id')
                  ->nullable()
                  ->constrained('pt')
                  ->nullOnDelete();

            // Jenis transaksi
            $table->enum('jenis_transaksi', [
                'membership',
                'pt_session'
            ]);

            // Detail membership
            $table->unsignedTinyInteger('membership_months')->nullable();

            // Detail sesi PT
            $table->unsignedInteger('jumlah_sesi')->nullable();

            // Informasi harga
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('total_harga', 12, 2);

            // Pembayaran
            $table->string('metode_pembayaran')->nullable();
            $table->string('bukti_pembayaran')->nullable();

            // Status transaksi
            $table->enum('status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            // Admin yang memproses transaksi
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('admin')
                  ->nullOnDelete();

            $table->timestamp('tanggal_transaksi')->useCurrent();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
