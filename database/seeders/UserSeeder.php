<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Maltha',
                'last_name' => 'Telenga',
                'username' => 'telenga',
                'role' => 'super-admin',
                'email_verified_at' => now(),
                'email' => 'malthatelenga22@gmail.com',
                'password' => bcrypt('12345678'),
            ]
        ];


        foreach ($users as $key => $user) {
            User::firstOrCreate(collect($user)->except('role')->toArray())->assignRole($user['role']);
        }
    }
}
