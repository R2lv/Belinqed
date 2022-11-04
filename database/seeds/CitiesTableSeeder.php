<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'country_id'=>'1',
            'title_en'=>'Tbilisi',
            'title_ka'=>"თბილისი",
        ]);
        DB::table('cities')->insert([
            'country_id'=>'1',
            'title_en'=>'Batumi',
            'title_ka'=>"ბათუმი",
        ]);
    }
}
