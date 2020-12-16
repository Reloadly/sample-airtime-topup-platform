<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use OTIFSolutions\ACLMenu\Models\UserRole;
use OTIFSolutions\ACLMenu\Models\Permission;

class DefaultUserPermissionsSync extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ADMIN PERMISSIONS
        $userRole = UserRole::where(['name' => 'ADMIN'])->first();
        $permissions = Permission::whereIn('menu_item_id',$userRole->menu_items()->pluck('id'))->pluck('id');
        $userRole->permissions()->sync($permissions);

        //RESELLER PERMISSIONS
        $userRole = UserRole::where(['name' => 'RESELLER'])->first();
        $permissions = Permission::whereIn('menu_item_id',$userRole->menu_items()->pluck('id'))->pluck('id');
        $userRole->permissions()->sync($permissions);

        //CUSTOMER PERMISSIONS
        $userRole = UserRole::where(['name' => 'CUSTOMER'])->first();
        $permissions = Permission::whereIn('menu_item_id',$userRole->menu_items()->pluck('id'))->pluck('id');
        $userRole->permissions()->sync($permissions);
    }
}
