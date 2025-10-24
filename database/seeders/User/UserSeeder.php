<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => '1@1.ru',
                'password' => Hash::make('123456')
            ],
            [
                'name' => 'user',
                'email' => '2@2.ru',
                'password' => Hash::make('123456')
            ]
        ];

        foreach ($users as $user) {
            User::query()->create($user);
        }
    }
}
