<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user = User::firstOrCreate(
			[
				'email' => 'admin@ra.ru',
			],
			[
				'name' => 'Admin',
				'password' => 'Hflbj13',
			]
		);
		
		// if (!$user->hasRole('admin')) {
			// $admin = \App\Role::where('name', 'admin')->first();
			
			// $user->attachRole($admin);
			// $user->save();
		// }
    }
}
