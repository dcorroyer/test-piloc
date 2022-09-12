<?php

namespace Database\Seeders;

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
        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create();

            DB::table('users_roles')->insert([
                'user_id' => $user->id,
                'role_id' => 1
            ]);

            DB::table('users_roles')->insert([
                'user_id' => $user->id,
                'role_id' => 2
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create();

            DB::table('users_roles')->insert([
                'user_id' => $user->id,
                'role_id' => 2
            ]);
        }
    }
}
