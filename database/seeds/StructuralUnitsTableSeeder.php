<?php

use Illuminate\Database\Seeder;
use App\Models\References\StructuralUnit;

class StructuralUnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		if(!StructuralUnit::withoutGlobalScopes()->first()){
			StructuralUnit::create([
				'name' => 'Руководящий состав',
			]);
			
			StructuralUnit::create([
				'name' => 'Техническая служба',
			]);
			
			StructuralUnit::create([
				'name' => 'Лаборатория спецпроверок',
			]);
			
			StructuralUnit::create([
				'name' => 'Служба безопасности',
			]);
			
			StructuralUnit::create([
				'name' => 'Отдел кадров',
			]);
			
			StructuralUnit::create([
				'name' => 'Бухгалтерия',
			]);
			
			StructuralUnit::create([
				'name' => 'Планово-экономический отдел',
			]);
			
			StructuralUnit::create([
				'name' => 'Юридическая служба',
			]);
			
			StructuralUnit::create([
				'name' => 'Служба качества',
			]);
			
			StructuralUnit::create([
				'name' => 'Научно-технический центр',
			]);
			
			StructuralUnit::create([
				'name' => 'Коммерческая служба',
			]);
			
			StructuralUnit::create([
				'name' => 'Отдел специальных проектов',
			]);
			
			StructuralUnit::create([
				'name' => 'Центр сервисного обслуживания',
			]);
			
			StructuralUnit::create([
				'name' => 'Испытательная лаборатория',
			]);
			
			StructuralUnit::create([
				'name' => 'ПРЕДСТАВИТЕЛЬСТВО в г. Санкт-Петербург',
			]);
		}
    }
}
