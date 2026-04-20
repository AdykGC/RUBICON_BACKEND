<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('bitrix_portals', function (Blueprint $table) {
            $table->id();
            $table->string('member_id')->unique();      // Уникальный ID портала
            $table->string('domain');                   // Домен портала
            $table->text('access_token');               // Текущий токен доступа
            $table->text('refresh_token');              // Токен для обновления
            $table->string('client_endpoint');          // URL для REST-вызовов
            $table->timestamp('expires_at');            // Время жизни access_token

            $table->string('application_token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bitrix_portals');
    }
};
