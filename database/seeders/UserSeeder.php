<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'lastname'  => 'toto',
            'firstname' => 'titi',
            'email'     => 'toto@gmail.com',
            'password'  => 'password',
            'role_id'   => 1
        ]);
    }
}
