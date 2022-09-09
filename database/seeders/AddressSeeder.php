<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('addresses')->insert([
            'street'      => 'toto la street',
            'postal_code' => '75013',
            'city'        => 'Paris',
        ]);
    }
}
