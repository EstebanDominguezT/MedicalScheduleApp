<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = [
            [
                'name' => 'Masculino',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Femenino',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'No binario',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Transgénero',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Género fluido',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Agénero',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bigénero',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Otro',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Prefiero no decir',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('genders')->insert($genders);
    }
}
