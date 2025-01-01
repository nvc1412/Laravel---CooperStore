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
        // DB::table('users')->insert([
        //     [
        //         'name' => 'nvc',
        //         'email' => 'nvc14122002@gmail.com',
        //         'password' => Hash::make('cuong14122002'),
        //         'phone' => '0365042941',
        //         'address' => '235 Hoàng Quốc Việt',
        //         'is_admin' => 1,
        //         'status' => 0,
        //         'remember_token' => null,
        //         'email_verified_at' => now(),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'abc',
        //         'email' => 'namdung406@gmail.com',
        //         'password' => Hash::make('cuong14122002'),
        //         'phone' => '0987654321',
        //         'address' => '235 Hoàng Quốc Việt, Bắc Từ Liêm, Hà Nội',
        //         'is_admin' => 0,
        //         'status' => 0,
        //         'remember_token' => null,
        //         'email_verified_at' => now(),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]
        // ]);

        \App\Models\User::factory(50)->create();
    }
}