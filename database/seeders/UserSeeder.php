<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'first_name' => 'Влад',
            'last_name' => 'Неверов',
            'gender' => 'm',
            'location' => 'Украина',
            'verify' => 1,
        ]);
    }
}
