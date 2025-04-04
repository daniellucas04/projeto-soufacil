<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Default admin user
        DB::table('users')->insert([
            'name' => 'master',
            'email' => 'master@email.com',
            'role' => 'master',
            'password' => Hash::make('master123'),
            'created_at' => (new \DateTime()),
            'updated_at' => (new \DateTime()),
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'created_at' => (new \DateTime()),
            'updated_at' => (new \DateTime()),
        ]);

        User::factory()
            ->count(50)
            ->create();
    }
}
