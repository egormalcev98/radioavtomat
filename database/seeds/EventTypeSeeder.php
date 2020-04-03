<?php

use Illuminate\Database\Seeder;
use App\Models\References\EventType;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!EventType::withoutGlobalScopes()->first()){
			
			EventType::create([
				'name' => 'Рассмотрение документа',
			]);
			
			EventType::create([
				'name' => 'Согласование с руководством',
			]);
			
			EventType::create([
				'name' => 'Личное',
			]);
			
			EventType::create([
				'name' => 'Совещание',
			]);
			
		}
    }
}
