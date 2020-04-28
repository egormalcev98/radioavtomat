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

        $headOfDepartment = Permission::firstOrCreate([
            'name' => 'head_of_department',
            'display_name' => 'Начальник своего отдела',
        ]);

        $deleteNote = Permission::firstOrCreate([
            'name' => 'delete_any_note',
            'display_name' => 'Удалять служебные записки',
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
        $this->do($roles, [$headOfDepartment]);

        $roles = [
            'secretary',
        ];
       $this->do($roles, [$orders]);

        $roles = [
            'general_manager'
        ];
        $this->do($roles, [$orders, $deleteNote]);

        $roles = [
            'admin'
        ];
        $this->do($roles, [$orders, $deleteNote, $deleteNote]);

        // syncPermissions перетерает предыдущие пермишонсы, поэтому если одной роли надо несколько пермишонсов то надо делать syncPermissions со всеми

    }

    public function do($roles, $permissions)
    {
        foreach ($roles as $role) {
            $user = Role::where('name', $role)->first();
            $user->syncPermissions($permissions);
        }
    }
}
