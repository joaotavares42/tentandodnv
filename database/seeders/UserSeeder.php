<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Joao Tavares',
            'email' => 'joao.santos@axxispay.com.br',
            'telephone' => '19-982204447',
            'gender' => 'M',
            'document_type' => 'CNPJ',
            'document_number' => '53.747.765/0001-56',
            'birth_date' => '2000/05/16',
            'password' => Hash::make('12345678')
        ]);
        $user->address()->create([
            'street' => 'Rua Licuri',
            'number' => '116',
            'district' => 'Bairro Jardim Brasília (Zona Leste)',
            'city' => 'Sao Paulo',
            'estate' => 'SP',
            'cep' => '03585-090'
        ]);
        $user->account()->create([
            'password' => Hash::make('123456')
        ]);
        $usera = User::create([
            'name' => 'UserTeste',
            'email' => 'jvdst5@gmail.com',
            'telephone' => '19-983143758',
            'gender' => 'M',
            'document_type' => 'CPF',
            'document_number' => '000.000.000-25',
            'birth_date' => '2000/05/16',
            'password' => Hash::make('12345678')
        ]);
        $usera->address()->create([
            'street' => 'Rua Licuri',
            'number' => '116',
            'district' => 'Bairro Jardim Brasília (Zona Leste)',
            'city' => 'Sao Paulo',
            'estate' => 'SP',
            'cep' => '03585-090'
        ]);
        $usera->account()->create([
            'password' => Hash::make('123456')
        ]);

    }
}
