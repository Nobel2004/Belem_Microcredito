<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcelas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('emprestimo_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->integer('numero');

            $table->decimal('valor', 12, 2);

            $table->date('vencimento');

            $table->enum('status', [
                'pendente',
                'pago',
                'atrasado'
            ])->default('pendente');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcelas');
    }
};