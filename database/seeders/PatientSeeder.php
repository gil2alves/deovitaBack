<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Patient::create(
            [
                'user_id' => 3,
                'cpf' => '03468678193',
                'sex' => 'm', 
                'date_birth' => '1970-01-03',
                'phone' => '6299225566',
                'address' => '1234 Main St',
                'city' => 'Goiania',
                'state' => 'GO',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
