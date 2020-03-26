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
        UserStatus::firstOrCreate([
            'name' => 'Активен',
        ]);
		
        UserStatus::firstOrCreate([
            'name' => 'Неактивен',
        ]);
    }
}
