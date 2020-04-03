<?php

use Illuminate\Database\Seeder;
use App\Models\References\CategoryNote;

class CategoryNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!CategoryNote::withoutGlobalScopes()->first()){
			
			CategoryNote::create([
				'name' => 'Информационная',
			]);
			
			CategoryNote::create([
				'name' => 'Пояснительная',
			]);
			
			CategoryNote::create([
				'name' => 'Сопроводительная',
			]);
			
			CategoryNote::create([
				'name' => 'Уведомительная',
			]);
			
			CategoryNote::create([
				'name' => 'Служебка',
			]);
			
			CategoryNote::create([
				'name' => 'Обращение к руководству',
			]);
			
		}
    }
}
