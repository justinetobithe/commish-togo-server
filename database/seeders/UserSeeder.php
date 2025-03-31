<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('users')->insert([
            [
                'first_name' => 'Admin',
                'last_name' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => null,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'first_name' => 'Adrian',
                'last_name' => 'Masesar',
                'email' => 'aMasesar@mcm.edu.ph',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '947403991',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'first_name' => 'Ellaine Criselle',
                'last_name' => 'Cortezano',
                'email' => 'ecCortezano@mcm.edu.ph',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '9952064439',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'first_name' => 'Alyx Jessie',
                'last_name' => 'Legaspi',
                'email' => 'ajLegaspi@mcm.edu.ph',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '9933055077',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'first_name' => 'Vince Joseph',
                'last_name' => 'Losdoc',
                'email' => 'vjLosdoc@mcm.edu.ph',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '9391011076',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'first_name' => 'Troy',
                'last_name' => 'Garcia',
                'email' => 'tvGarcia@mcm.edu.ph',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '9566135879',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
