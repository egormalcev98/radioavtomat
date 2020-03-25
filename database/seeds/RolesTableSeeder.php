<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::updateOrCreate([
            'name' => 'admin',
        ], [
            'display_name' => 'Администратор',
            'description' => '',
			'without_destroy' => 1,
		]);
    }
}
