
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pt', function (Blueprint $table) {
            $table->dropColumn('split_gym');
        });

        Schema::table('pt_profiles', function (Blueprint $table) {
            $table->dropColumn('split_gym');
        });
    }

    public function down(): void
    {
        Schema::table('pt', function (Blueprint $table) {
            $table->enum('split_gym', [
                'Push Day',
                'Pull Day',
                'Leg Day',
                'Upper Body',
                'Lower Body',
                'Full Body',
            ])->nullable();
        });

        Schema::table('pt_profiles', function (Blueprint $table) {
            $table->string('split_gym')->nullable();
        });
    }
};
