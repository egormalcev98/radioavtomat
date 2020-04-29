<?php

use Illuminate\Database\Seeder;
use App\Models\Tasks\TaskType;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!TaskType::first()){

            TaskType::create([
				'name' => 'Задача',
				'system_name' => 'task',
                'color' => 'DarkBlue',
                'text_color' => 'White'
			]);

            TaskType::create([
				'name' => 'Приказ',
                'system_name' => 'order',
				'color' => 'Black',
				'text_color' => 'White'
			]);

		}
    }
}
