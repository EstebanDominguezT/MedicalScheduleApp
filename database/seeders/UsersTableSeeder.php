<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'estebantalavera17@gmail.com',
                'password' => Hash::make('esteband1'),
                'role_id' => 1,
                'person_id' => 1,
            ],
            [
                'email' => 'mariaelena.gonzalez@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 3,
                'person_id' => 2,
            ],
            [
                'email' => 'javierantonio.perez@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 2,
                'person_id' => 3,
            ],
            [
                'email' => 'luisafernanda.rodriguez@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 3,
                'person_id' => 4,
            ],
            [
                'email' => 'carloseduardo.martinez@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 2,
                'person_id' => 5,
            ],
            [
                'email' => 'anasofia.lopez@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 3,
                'person_id' => 6,
            ],
            [
                'email' => 'ricardojose.hernandez@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 2,
                'person_id' => 7,
            ],
            [
                'email' => 'isabelmaria.ramirez@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 3,
                'person_id' => 8,
            ],
            [
                'email' => 'fernandoraul.vargas@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 2,
                'person_id' => 9,
            ],
            [
                'email' => 'carmenluz.moreno@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 3,
                'person_id' => 10,
            ],
            [
                'email' => 'gabrielalonso.ortiz@example.com',
                'password' => Hash::make('123456!'),
                'role_id' => 2,
                'person_id' => 11,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'email' => $userData['email'],
                'password' => $userData['password'],
                'role_id' => $userData['role_id'],
                'person_id' => $userData['person_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            switch ($userData['role_id']) {
                case 1:
                    $user->assignRole('administrator');
                    break;
                case 2:
                    $user->assignRole('doctor');
                    break;
                case 3:
                    $user->assignRole('employee');
                    break;
            }
        }
    }
}
