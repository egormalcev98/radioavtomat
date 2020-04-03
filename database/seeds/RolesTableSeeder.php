<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate([
            'name' => 'admin',
        ], [
            'display_name' => 'Администратор',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'general_manager',
        ], [
            'display_name' => 'Генеральный директор',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_gen_man_quality',
        ], [
            'display_name' => 'Заместитель генерального директора по качеству',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_gen_man_adm',
        ], [
            'display_name' => 'Заместитель генерального директора по административно-хозяйственной деятельности',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'first_deputy_gen_man',
        ], [
            'display_name' => 'Первый заместитель генерального директора',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'technical_director',
        ], [
            'display_name' => 'Технический директор',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'commercial_director',
        ], [
            'display_name' => 'Коммерческий директор',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_gen_man_spec',
        ], [
            'display_name' => 'Заместитель генерального директора по специальным проектам',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_gen_man_security',
        ], [
            'display_name' => 'Заместитель генерального директора по безопасности',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_gen_man_industry',
        ], [
            'display_name' => 'Заместитель генерального директора по производству и технической деятельности',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'metrolog',
        ], [
            'display_name' => 'Метролог',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_special_laboratory',
        ], [
            'display_name' => 'Начальник лаборатории спецпроверок',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'leading_eng_special_laboratory',
        ], [
            'display_name' => 'Ведущий инженер лаборатории спецпроверок',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'junior_specialist',
        ], [
            'display_name' => 'Младший специалист',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_human_resources',
        ], [
            'display_name' => 'Руководитель отдела кадров',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'accountant',
        ], [
            'display_name' => 'Бухгалтер',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_accountant',
        ], [
            'display_name' => 'Заместитель главного бухгалтера',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'chief_accountant',
        ], [
            'display_name' => 'Главный бухгалтер',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'lead_accountant',
        ], [
            'display_name' => 'Ведущий бухгалтер',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'economist',
        ], [
            'display_name' => 'Экономист',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_economist',
        ], [
            'display_name' => 'Руководитель планово-экономического отдела',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_head_economist',
        ], [
            'display_name' => 'Заместитель руководителя планово-экономического отдела',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'lawyer',
        ], [
            'display_name' => 'Юрист',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_lawyer',
        ], [
            'display_name' => 'Руководитель юридической службы',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'lead_lawyer',
        ], [
            'display_name' => 'Ведущий юрист',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'incoming_inspection_technician',
        ], [
            'display_name' => 'Техник входного контроля',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'technical_documentation_engineer',
        ], [
            'display_name' => 'Инженер по технической документации',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'quality_manager',
        ], [
            'display_name' => 'Руководитель службы качества',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'regulatory_specialist',
        ], [
            'display_name' => 'Специалист по нормоконтролю',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'process_control_specialist',
        ], [
            'display_name' => 'Специалист по технологическому контролю',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'control',
        ], [
            'display_name' => 'Контролер',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'occupational_safety_engineer',
        ], [
            'display_name' => 'Инженер по охране труда',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'civil_defens_engineer',
        ], [
            'display_name' => 'Инженер по гражданской обороне и чрезвычайным ситуациям',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_information_technology',
        ], [
            'display_name' => 'Руководитель службы информационных технологий («Администратор» системы)',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'system_administrator_assistant',
        ], [
            'display_name' => 'Помощник системного администратора',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_technical_center',
        ], [
            'display_name' => 'Начальник научно-технического центра',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_head_technical_center',
        ], [
            'display_name' => 'Заместитель начальника научно-технического центра',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'design_engineer',
        ], [
            'display_name' => 'Инженер-конструктор',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'lead_design_engineer',
        ], [
            'display_name' => 'Ведущий инженер-конструктор',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_design_engineer',
        ], [
            'display_name' => 'Старший инженер-конструктор',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_commercial_services',
        ], [
            'display_name' => 'Руководитель коммерческой службы',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'tender_manager',
        ], [
            'display_name' => 'Менеджер по тендерам',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'contract_manager',
        ], [
            'display_name' => 'Менеджер по договорной работе',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'lead_contract_manager',
        ], [
            'display_name' => 'Ведущий менеджер по договорной работе',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_contract',
        ], [
            'display_name' => 'Руководитель договорного отдела',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'purchasing_manager',
        ], [
            'display_name' => 'Менеджер по закупкам',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_rocurement_department',
        ], [
            'display_name' => 'Руководитель отдела снабжения',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'technical_specialist',
        ], [
            'display_name' => 'Технический специалист',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'storekeeper',
        ], [
            'display_name' => 'Кладовщик',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_storekeeper',
        ], [
            'display_name' => 'Начальник склада',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_special_projects',
        ], [
            'display_name' => 'Руководитель отдела специальных проектов',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_service_center',
        ], [
            'display_name' => 'Начальник центра сервисного обслуживания',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_head_service_center',
        ], [
            'display_name' => 'Заместитель начальника центра сервисного обслуживания',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_testing_laboratory',
        ], [
            'display_name' => 'Начальник испытательной лаборатории',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'deputy_head_testing_laboratory',
        ], [
            'display_name' => 'Заместитель начальника испытательной лаборатории',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        // Role::firstOrCreate([
            // 'name' => 'technical_documentation_engineer',
        // ], [
            // 'display_name' => 'Инженер по технической документации',
            // 'description' => '',
			// 'without_destroy' => 1,
		// ]);
		
        Role::firstOrCreate([
            'name' => 'head_technical_documentation',
        ], [
            'display_name' => 'Начальник службы технической документации',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'engineer',
        ], [
            'display_name' => 'Инженер',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_incoming_control',
        ], [
            'display_name' => 'Начальник отдела входного контроля',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'technician',
        ], [
            'display_name' => 'Техник',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_parametric_control',
        ], [
            'display_name' => 'Начальник отдела параметрического контроля',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'microwave_component_engineer',
        ], [
            'display_name' => 'Инженер-испытатель СВЧ компонентов',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_test_site',
        ], [
            'display_name' => 'Начальник испытательного участка',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_tooling_development',
        ], [
            'display_name' => 'Начальник отдела разработки технологической оснастки',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'head_branch',
        ], [
            'display_name' => 'Руководитель представительства',
            'description' => '',
			'without_destroy' => 1,
		]);
		
        Role::firstOrCreate([
            'name' => 'sales_manager',
        ], [
            'display_name' => 'Менеджер по продажам',
            'description' => '',
			'without_destroy' => 1,
		]);
    }
}
