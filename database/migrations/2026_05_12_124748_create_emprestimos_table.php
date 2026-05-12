<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('emprestimos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('cliente_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->decimal('valor', 12, 2);

            $table->decimal('taxa_juros', 5, 2);

            $table->integer('prazo_meses');

            $table->decimal('valor_total', 12, 2);

            $table->enum('status', [
                'pendente',
                'aprovado',
                'rejeitado',
                'finalizado'
            ])->default('pendente');

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
    }
};