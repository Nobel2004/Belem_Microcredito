<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->foreignId('role_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('roles')
                  ->nullOnDelete();

            $table->string('telefone')
                  ->nullable()
                  ->after('email');

            $table->enum('status', [
                'ativo',
                'inativo'
            ])->default('ativo')
              ->after('telefone');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['role_id']);

            $table->dropColumn([
                'role_id',
                'telefone',
                'status'
            ]);

        });
    }
};