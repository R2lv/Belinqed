<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table("users")->insert([
			'name'=>'Giorgi',
			'surname'=>'Tabatadze',
			'email'=>'android.giorgi@gmail.com',
			'password'=>bcrypt("qweasd123"),
			'mobile_number'=>'598446587',
			'personal_id'=>'57001057506',
			'email_verified'=>1,
			'mobile_verified'=>1,
			'gender'=>'male',
			'city_id'=>1,
			'birthday'=>'1996-04-12'
		]);
    }
}