<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class PermissionTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Permission::firstOrCreate([
            'name' => 'orders_access',
            'display_name' => 'Доступ к приказам',
        ]);
        $roles = [
            'secretary',
            'general_manager'
        ];
        foreach ($roles as $role) {
            $user = Role::where('name', $role)->first();
            $user->syncPermissions([$orders]);
        }

        $headOfDepartment = Permission::firstOrCreate([
            'name' => 'head_of_department',
            'display_name' => 'Начальник своего отдела',
        ]);
        $roles = [
            'head_special_laboratory',
            'head_human_resources',
            'chief_accountant',
            'head_economist',
            'head_economist',
            'head_lawyer',
            'quality_manager',
            'head_information_technology',
            'head_technical_center',
            'head_commercial_services',
            'head_contract',
            'head_rocurement_department',
            'head_storekeeper',
            'head_special_projects',
            'head_service_center',
            'head_testing_laboratory',
            'head_technical_documentation',
            'head_incoming_control',
            'head_parametric_control',
            'head_test_site',
            'head_tooling_development',
            'head_branch',
        ];
        foreach ($roles as $role) {
            $user = Role::where('name', $role)->first();
            $user->syncPermissions([$headOfDepartment]);
        }

        // syncPermissions перетерает предыдущие пермишонсы, поэтому если одной роли надо несколько пермишонсов
        // то надо делать syncPermissions со всеми как в примерн с админом
        $user = Role::where('name', 'admin')->first();
        $user->syncPermissions([$orders, $headOfDepartment]);

    }
}
