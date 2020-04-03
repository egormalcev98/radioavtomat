<?php

use Illuminate\Database\Seeder;
use App\Models\References\UserStatus;

class UserStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!UserStatus::withoutGlobalScopes()->first()){
			UserStatus::create([
				'name' => 'Активен',
			]);
			
			UserStatus::create([
				'name' => 'Неактивен',
			]);
		}
    }
}
