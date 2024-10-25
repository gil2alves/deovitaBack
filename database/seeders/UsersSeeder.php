<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'Gil Alves da Silveira',
                'email' => 'gil2alves@gmail.com',
                'name_user' => 'gilneto',
                'password' => Hash::make('123456'),
                'group_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Medico Teste',
                'email' => 'medico01@mail.com',
                'name_user' => 'medico01',
                'password' => Hash::make('123456'),
                'group_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paciente Teste',
                'email' => 'paciente01@mail.com',
                'name_user' => 'paciente01',
                'password' => Hash::make('123456'),
                'group_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
