<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penhores', function (Blueprint $table) {

            $table->id();

            $table->foreignId('emprestimo_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('descricao');

            $table->decimal('valor_avaliado', 12, 2);

            $table->string('imagem')->nullable();

            $table->enum('status', [
                'guardado',
                'devolvido',
                'leiloado'
            ])->default('guardado');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penhores');
    }
};