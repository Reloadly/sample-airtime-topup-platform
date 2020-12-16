<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //OTIF Solutions ACL Requirement Start
        $this->call(UserRolesTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
        Artisan::call('aclmenu:refresh');
        $this->call(DefaultUserPermissionsSync::class);
        //OTIF Solutions ACL Requirement END

        $this->call(UsersTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(TimezonesTableSeeder::class);

    }
}
