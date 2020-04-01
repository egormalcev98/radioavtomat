<?php

use Illuminate\Database\Seeder;
use App\Models\References\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!DocumentType::first()){
			
			DocumentType::create([
				'name' => 'Письмо',
			]);
			
			DocumentType::create([
				'name' => 'Договор',
			]);
			
			DocumentType::create([
				'name' => 'Сопроводительное',
			]);
			
			DocumentType::create([
				'name' => 'Заказ',
			]);
			
		}
    }
}
