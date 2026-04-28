<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('location')->nullable();
            $table->string('mac_address')->unique()->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('connection_type')->nullable();
            $table->decimal('install_price', 10, 2)->nullable();
            $table->decimal('price_adjustment', 10, 2)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->decimal('balance', 12, 2)->default(0);
            
            $table->string('qr_code')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Создаём таблицу пополнений
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('transaction_id')->nullable(); // ID от Kaspi
            $table->timestamps();
        });

        Schema::create('device_commands', function (Blueprint $table) {
            $table->id();
            $table->string('mac_address'); // ESP32 MAC
            $table->string('command_id')->unique();
            $table->string('action');
            $table->integer('pulses')->nullable();
            $table->string('status')->default('pending'); 
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('device_commands');
        Schema::dropIfExists('transactions'); // Transactions
        Schema::dropIfExists('machines');
    }
};
