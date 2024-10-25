<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Doctor::create(
            [
                'user_id' => 2,
                'crm' => '12345',
                'cpf' => '79052652007',
                'sex' => 'm', 
                'date_birth' => '1975-03-06',
                'phone' => '1234567890',
                'address' => '1234 santa genoveva St',
                'city' => 'Goiania',
                'state' => 'GO',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
