
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Informasi akun
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // Informasi pribadi
            $table->string('phone', 20)->nullable();

            // Jenis akun
            $table->enum('role', ['member', 'admin', 'pt'])
                  ->default('member');

            // Status membership
            $table->enum('membership_status', [
                'inactive',
                'active',
                'expired'
            ])->default('inactive');

            // Periode membership
            $table->date('membership_start')->nullable();
            $table->date('membership_end')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
