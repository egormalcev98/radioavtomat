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
        StructuralUnit::firstOrCreate([
            'name' => 'Руководящий состав',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Техническая служба',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Лаборатория спецпроверок',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Служба безопасности',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Отдел кадров',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Бухгалтерия',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Планово-экономический отдел',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Юридическая служба',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Служба качества',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Научно-технический центр',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Коммерческая служба',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Отдел специальных проектов',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Центр сервисного обслуживания',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'Испытательная лаборатория',
        ]);
		
        StructuralUnit::firstOrCreate([
            'name' => 'ПРЕДСТАВИТЕЛЬСТВО в г. Санкт-Петербург',
        ]);
    }
}
