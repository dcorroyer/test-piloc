<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('properties')->insert([
            'wording'    => 'toto',
            'space'      => 25,
            'price'      => 500,
            'status'     => 'available',
            'user_id'    => 1,
            'address_id' => 1
        ]);
    }
}
