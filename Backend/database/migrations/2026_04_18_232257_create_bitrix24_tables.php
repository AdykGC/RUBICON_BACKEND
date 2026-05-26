<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('bitrix_portals', function (Blueprint $table) {
            $table->id();
            // Уникальный ID портала  |  Домен портала  |  URL для REST-вызовов
            $table->string('member_id')->unique();
            $table->string('domain');
            $table->string('client_endpoint');
            // Текущий токен доступа  |  Токен для обновления  |  Время жизни access_token
            $table->string('access_token', 2048)->nullable();
            $table->string('refresh_token', 2048)->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->text('scope')->nullable();
            $table->string('application_token')->nullable();
            $table->enum('status', ['active', 'uninstalled', 'suspended'])->default('active');
            $table->timestamp('uninstalled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bitrix_portals');
    }
};
