<?php

use Illuminate\Database\Seeder;
use App\Models\References\EmployeeTask;

class EmployeeTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!EmployeeTask::withoutGlobalScopes()->first()) {
			
			EmployeeTask::create([
				'name' => 'Ознакомиться',
			]);
			
			EmployeeTask::create([
				'name' => 'В работу',
			]);
			
			EmployeeTask::create([
				'name' => 'Обсудить с руководителем',
			]);
		}
    }
}
