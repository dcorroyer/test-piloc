<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $names = ['admin', 'landlord'];

        collect($names)->each(function($name) {
            Role::factory()->create(['name' => $name]);
        });
    }
}
