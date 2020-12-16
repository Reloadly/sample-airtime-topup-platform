<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use OTIFSolutions\ACLMenu\Models\UserRole;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRole::updateOrCreate(['id' => 1],['name' => 'ADMIN']);
        UserRole::updateOrCreate(['id' => 2],['name' => 'RESELLER']);
        UserRole::updateOrCreate(['id' => 3],['name' => 'CUSTOMER']);
    }
}
