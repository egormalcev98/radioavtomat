<?php

use Illuminate\Database\Seeder;
use App\Models\References\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!TaskStatus::withoutGlobalScopes()->first()) {
			
			TaskStatus::create([
				'name' => 'Новая задача',
			]);
			
			TaskStatus::create([
				'name' => 'Выполнено',
			]);
			
			TaskStatus::create([
				'name' => 'Просрочено',
			]);
		}
    }
}
