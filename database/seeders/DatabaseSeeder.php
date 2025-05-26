<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // DB::table('role_user_permits')->insert([
        //     'name_role_user' => 'Administrator ',
           
        // ]);
        DB::table('users')->insert([
            'name' => 'Yoman',
            'username' => 'yoman.denis',
            'role_user_permit_id' => 1,
            'email' => Str::random(10).'@example.com',
            'email' => Str::random(10).'@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
