<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     *
     * Groups
     * 1 - comuns
     * 2 - lojista
     *
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Diego',
            'last_name' => 'Lopes',
            'document' => '11918687706',
            'email' => 'diego@localhost.com',
            'group' => 1,
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'D+B',
            'last_name' => 'Digital Things',
            'document' => '32730790000157',
            'email' => 'diego@dbdigitalthings.com',
            'group' => 2,
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Hebert',
            'last_name' => 'Boom',
            'document' => '11111111111',
            'email' => 'hebert@dbdigitalthings.com',
            'group' => 2,
            'password' => Hash::make('123'),
        ]);
    }
}
