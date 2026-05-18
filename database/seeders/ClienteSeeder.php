<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'adminBelem@Gmail.com')->first();

        $clientes = [
            [
                'nome'         => 'Nobel Taylor',
                'bi'           => '006123456LA041',
                'telefone'     => '833217220',
                'endereco'     => 'Matola, Fomento, Sial',
                'renda_mensal' => 15000,
            ],
            [
                'nome'         => 'Amelia',
                'bi'           => '007234567LA042',
                'telefone'     => '879002331',
                'endereco'     => 'Matola, Fomento',
                'renda_mensal' => 20000,
            ],
           
        ];

        foreach ($clientes as $dados) {
            Cliente::firstOrCreate(
                ['bi' => $dados['bi']],
                [...$dados, 'created_by' => $admin->id]
            );
        }
    }
}