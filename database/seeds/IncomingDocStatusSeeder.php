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
				'name' => 'Ожидание подписи',
				'without_destroy' => 1,
			]);
			
			IncomingDocStatus::create([
				'name' => 'Подписан',
				'without_destroy' => 1,
			]);
			
			IncomingDocStatus::create([
				'name' => 'Просрочен',
				'without_destroy' => 1,
			]);
			
		}
    }
}
