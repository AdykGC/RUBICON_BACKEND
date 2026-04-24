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
            $table->string('serial_number')->nullable();
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
        Schema::create('top_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->string('transaction_id')->nullable(); // ID от Kaspi
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('machine_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('mac')->unique();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('device_commands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id');
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
        Schema::dropIfExists('devices');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('products');
        Schema::dropIfExists('top_ups');
        Schema::dropIfExists('machines');
    }
};
