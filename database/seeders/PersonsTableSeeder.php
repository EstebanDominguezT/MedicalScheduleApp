<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $persons = [
            [
                'first_name' => 'Esteban',
                'middle_name' => 'Carlos',
                'last_name' => 'Dominguez',
                'gender_id' => 1,
                'date_of_birth' => '2001-03-28',
                'national_id' => '5254804',
                'address' => 'Calle 1 # 2-3',
                'postal_code' => '12345',
                'phone_number' => '+5951234567890',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'María',
                'middle_name' => 'Elena',
                'last_name' => 'González',
                'gender_id' => 2,
                'date_of_birth' => '1990-11-20',
                'national_id' => '23456789',
                'address' => 'Avenida 3 # 4-5',
                'postal_code' => '54321',
                'phone_number' => '+5950987654321',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Javier',
                'middle_name' => 'Antonio',
                'last_name' => 'Pérez',
                'gender_id' => 1,
                'date_of_birth' => '1978-09-05',
                'national_id' => '34567890',
                'address' => 'Carrera 10 # 11-12',
                'postal_code' => '67890',
                'phone_number' => '+5951122334455',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Luisa',
                'middle_name' => 'Fernanda',
                'last_name' => 'Rodríguez',
                'gender_id' => 2,
                'date_of_birth' => '1983-02-12',
                'national_id' => '45678901',
                'address' => 'Calle 15 # 16-17',
                'postal_code' => '98765',
                'phone_number' => '+5955544332211',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Carlos',
                'middle_name' => 'Eduardo',
                'last_name' => 'Martínez',
                'gender_id' => 1,
                'date_of_birth' => '1987-04-23',
                'national_id' => '56789012',
                'address' => 'Avenida 7 # 8-9',
                'postal_code' => '19283',
                'phone_number' => '+5956677889900',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Ana',
                'middle_name' => 'Sofía',
                'last_name' => 'López',
                'gender_id' => 2,
                'date_of_birth' => '1992-08-19',
                'national_id' => '67890123',
                'address' => 'Carrera 20 # 21-22',
                'postal_code' => '38475',
                'phone_number' => '+5957788990011',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Ricardo',
                'middle_name' => 'José',
                'last_name' => 'Hernández',
                'gender_id' => 1,
                'date_of_birth' => '1975-01-30',
                'national_id' => '78901234',
                'address' => 'Calle 25 # 26-27',
                'postal_code' => '47638',
                'phone_number' => '+5958899001122',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Isabel',
                'middle_name' => 'María',
                'last_name' => 'Ramírez',
                'gender_id' => 2,
                'date_of_birth' => '1989-12-15',
                'national_id' => '89012345',
                'address' => 'Avenida 12 # 13-14',
                'postal_code' => '58473',
                'phone_number' => '+5959900112233',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Fernando',
                'middle_name' => 'Raúl',
                'last_name' => 'Vargas',
                'gender_id' => 1,
                'date_of_birth' => '1980-05-02',
                'national_id' => '90123456',
                'address' => 'Carrera 30 # 31-32',
                'postal_code' => '64829',
                'phone_number' => '+5950011223344',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Carmen',
                'middle_name' => 'Luz',
                'last_name' => 'Moreno',
                'gender_id' => 2,
                'date_of_birth' => '1995-07-08',
                'national_id' => '01234567',
                'address' => 'Calle 35 # 36-37',
                'postal_code' => '75294',
                'phone_number' => '+5952233445566',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Gabriel',
                'middle_name' => 'Alonso',
                'last_name' => 'Ortiz',
                'gender_id' => 1,
                'date_of_birth' => '1982-10-17',
                'national_id' => '10987654',
                'address' => 'Avenida 40 # 41-42',
                'postal_code' => '34928',
                'phone_number' => '+5953344556677',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('persons')->insert($persons);
    }
}
