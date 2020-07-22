<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([[
           'name' => 'Rabat',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'name' => 'Casa',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'name'=>'Tangier',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]]);
    }
}
