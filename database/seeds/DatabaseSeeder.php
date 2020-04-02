<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(UserStatusesTableSeeder::class);
        $this->call(StructuralUnitsTableSeeder::class);
        $this->call(DocumentTypeSeeder::class);
        $this->call(IncomingDocStatusSeeder::class);
    }
}
