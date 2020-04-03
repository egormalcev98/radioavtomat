<?php

use Illuminate\Database\Seeder;
use App\Models\References\OutgoingDocStatus;

class OutgoingDocStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!OutgoingDocStatus::withoutGlobalScopes()->first()) {
			
			OutgoingDocStatus::create([
				'name' => 'Новый документ',
			]);
			
			OutgoingDocStatus::create([
				'name' => 'На рассмотрении',
			]);
			
			OutgoingDocStatus::create([
				'name' => 'Отправлено',
			]);
		}
    }
}
