<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Emprestimos;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmprestimoSeeder extends Seeder
{
    public function run(): void
    {
        $admin    = User::where('email', 'admin@belem.ao')->first();
        $clientes = Cliente::all();

        // Empréstimo pendente (aguarda aprovação)
        Emprestimos::firstOrCreate(
            ['cliente_id' => $clientes[0]->id, 'status' => 'pendente'],
            [
                'valor'      => 30000,
                'juros'      => 10,
                'created_by' => $admin->id,
            ]
        );

        // Empréstimo aprovado (com parcelas geradas pelo Observer)
        $aprovado = Emprestimos::firstOrCreate(
            ['cliente_id' => $clientes[1]->id, 'status' => 'aprovado'],
            [
                'valor'      => 45000,
                'juros'      => 10,
                'created_by' => $admin->id,
            ]
        );

        // Gera parcelas manualmente se não existirem (o Observer não dispara em seeders)
        if ($aprovado->parcelas()->doesntExist()) {
            app(\App\Services\ParcelaService::class)->gerar($aprovado, 12);
        }
    }
}