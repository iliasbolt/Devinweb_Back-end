<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class PartnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partners')->insert([[
            'name' => 'Mohammed',
            'city_id' => 1 ,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ], [
            'name' => 'Hassan',
            'city_id' => 2 ,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ],[
            'name'=>'Nada',
            'city_id' => 3 ,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]]);
    }
}
