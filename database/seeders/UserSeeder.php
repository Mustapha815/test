<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mustapha',
            'phone' => '0600000000',
            'role' => 'admin',
            'password' => Hash::make('123456'), // هنا خاصك تستعمل Hash::make باش يدير bcrypt
   ]);

    }
}
