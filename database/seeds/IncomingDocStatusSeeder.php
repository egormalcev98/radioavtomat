<?php

use Illuminate\Database\Seeder;
use App\Models\References\IncomingDocStatus;

class IncomingDocStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!IncomingDocStatus::withoutGlobalScopes()->first()){
			
			IncomingDocStatus::create([
				'name' => 'Новый документ',
			]);
			
			IncomingDocStatus::create([
				'name' => 'На рассмотрении',
			]);
			
			IncomingDocStatus::create([
				'name' => 'Подписан',
			]);
		}
    }
}
