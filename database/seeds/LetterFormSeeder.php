<?php

use Illuminate\Database\Seeder;
use App\Models\References\LetterForm;

class LetterFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!LetterForm::withoutGlobalScopes()->first()){
			
			LetterForm::create([
				'name' => 'Ознакомиться',
			]);
			
			LetterForm::create([
				'name' => 'В работу',
			]);
			
			LetterForm::create([
				'name' => 'Обсудить с руководителем',
			]);
			
		}
    }
}
