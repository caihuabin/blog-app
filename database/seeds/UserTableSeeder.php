<?php
use Illuminate\Database\Seeder;
class UserTableSeeder extends Seeder {
	
	public function run()
	{

		$user = Sentinel::registerAndActivate([
			'email'      => 'cai@cai.com',
		  	'password'   => "cccccc",
		  	'name' => 'cai'
		]);

	}
}