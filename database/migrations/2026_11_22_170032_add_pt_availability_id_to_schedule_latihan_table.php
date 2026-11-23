
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedule_latihan', function (Blueprint $table) {
            $table->foreignId('pt_availability_id')
                ->nullable()
                ->after('transaksi_id')
                ->constrained('pt_availabilities')
                ->nullOnDelete();

            $table->index('pt_availability_id');
        });
    }

    public function down(): void
    {
        Schema::table('schedule_latihan', function (Blueprint $table) {
            $table->dropForeign(['pt_availability_id']);
            $table->dropIndex(['pt_availability_id']);
            $table->dropColumn('pt_availability_id');
        });
    }
};
