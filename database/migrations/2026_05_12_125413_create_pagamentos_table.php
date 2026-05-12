<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagamentos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('parcela_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->decimal('valor_pago', 12, 2);

            $table->date('data_pagamento');

            $table->foreignId('recebido_por')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagamentos');
    }
};