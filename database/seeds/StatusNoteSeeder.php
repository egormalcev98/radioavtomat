<?php

use Illuminate\Database\Seeder;
use App\Models\References\StatusNote;

class StatusNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!StatusNote::withoutGlobalScopes()->first()){
			
			StatusNote::create([
				'name' => 'Новая',
			]);
			
			StatusNote::create([
				'name' => 'На рассмотрении',
			]);
			
			StatusNote::create([
				'name' => 'Рассмотрена',
			]);
			
		}
    }
}
