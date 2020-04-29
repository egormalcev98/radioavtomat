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
                'without_destroy' => 1,
			]);

			StatusNote::create([
				'name' => 'На рассмотрении',
                'without_destroy' => 1,
			]);

			StatusNote::create([
				'name' => 'Рассмотрена',
                'without_destroy' => 1,
			]);

		}
    }
}
