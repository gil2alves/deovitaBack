<?php

namespace Database\Seeders;

use App\Models\Exam;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exam::insert([
            [
                'type_of_exam' => 'Hemograma',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_of_exam' => 'Colesterol',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type_of_exam' => 'Indice Glicemico',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
