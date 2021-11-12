<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use OTIFSolutions\ACLMenu\Models\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuItem::truncate();

        MenuItem::updateOrCreate(['id'=>1],['parent_id' => 0,'order_number' => 0,'icon' => 'feather icon-home','name' => 'Dashboard','route' => '/dashboard', 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([1,2,3]);
        MenuItem::updateOrCreate(['id'=>2],['parent_id' => 0,'order_number' => 1,'icon' => 'feather icon-user','name' => 'Profile','route' => '/profile', 'generate_permission' => 'MANAGE_ONLY', 'show_on_sidebar' => 0])->user_roles()->sync([1,2,3]);

        MenuItem::updateOrCreate(['id'=>3],['parent_id' => 0,'order_number' => 2,'icon' => 'feather icon-codepen','name' => 'Topups','route' => '/topups' , 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([1,2,3]);
        MenuItem::updateOrCreate(['id'=>4],['parent_id' => 3,'order_number' => 0,'icon' => 'feather icon-circle','name' => 'Send Topup','route' => '/topups/send' , 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([2,3]);
        MenuItem::updateOrCreate(['id'=>5],['parent_id' => 3,'order_number' => 1,'icon' => 'feather icon-circle','name' => 'Bulk Topup','route' => '/topups/bulk' , 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([2]);
        MenuItem::updateOrCreate(['id'=>6],['parent_id' => 3,'order_number' => 2,'icon' => 'feather icon-circle','name' => 'History','route' => '/topups/history' , 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([1,2,3]);
        MenuItem::updateOrCreate(['id'=>7],['parent_id' => 3,'order_number' => 3,'icon' => 'feather icon-circle','name' => 'Countries','route' => '/topups/countries', 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([1,2,3]);
        MenuItem::updateOrCreate(['id'=>8],['parent_id' => 3,'order_number' => 4,'icon' => 'feather icon-circle','name' => 'Operators','route' => '/topups/operators', 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([1,2,3]);
        MenuItem::updateOrCreate(['id'=>9],['parent_id' => 3,'order_number' => 5,'icon' => 'feather icon-circle','name' => 'Discounts','route' => '/topups/discounts', 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([1,2]);
        MenuItem::updateOrCreate(['id'=>20],['parent_id' => 3,'order_number' => 6,'icon' => 'feather icon-circle','name' => 'Promotions','route' => '/topups/promotions', 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([1,2,3]);

        MenuItem::updateOrCreate(['id'=>10],['parent_id' => 0,'order_number' => 3,'icon' => 'feather icon-users','name' => 'Users','route' => '/users'])->user_roles()->sync([1]);
        MenuItem::updateOrCreate(['id'=>11],['parent_id' => 10,'order_number' => 0,'icon' => 'feather icon-circle','name' => 'Resellers','route' => '/users/resellers'])->user_roles()->sync([1]);
        MenuItem::updateOrCreate(['id'=>12],['parent_id' => 10,'order_number' => 1,'icon' => 'feather icon-circle','name' => 'Customers','route' => '/users/customers'])->user_roles()->sync([1]);

        MenuItem::updateOrCreate(['id'=>13],['parent_id' => 0,'order_number' => 4,'icon' => 'feather icon-file-text','name' => 'Invoices','route' => '/invoices'])->user_roles()->sync([1,2,3]);

        MenuItem::updateOrCreate(['id'=>14],['parent_id' => 0,'order_number' => 5,'icon' => 'feather icon-briefcase','name' => 'Billings','route' => '/billings'])->user_roles()->sync([2,3]);

        MenuItem::updateOrCreate(['id'=>15],['parent_id' => 0,'order_number' => 6,'icon' => 'fa fa-money','name' => 'Wallet','route' => '/wallet'])->user_roles()->sync([1,2]);
        MenuItem::updateOrCreate(['id'=>16],['parent_id' => 15,'order_number' => 0,'icon' => 'feather icon-circle','name' => 'Account','route' => '/wallet/account'])->user_roles()->sync([2]);
        MenuItem::updateOrCreate(['id'=>17],['parent_id' => 15,'order_number' => 1,'icon' => 'feather icon-circle','name' => 'Accounts','route' => '/wallet/accounts'])->user_roles()->sync([1]);
        MenuItem::updateOrCreate(['id'=>18],['parent_id' => 15,'order_number' => 2,'icon' => 'feather icon-circle','name' => 'Transactions','route' => '/wallet/transactions'])->user_roles()->sync([1]);

        MenuItem::updateOrCreate(['id'=>19],['parent_id' => 0,'order_number' => 7,'icon' => 'feather icon-settings','name' => 'Settings','route' => '/settings', 'generate_permission' => 'MANAGE_ONLY'])->user_roles()->sync([1]);

        MenuItem::updateOrCreate(['id'=>20],['parent_id' => 0,'order_number' => 8,'icon' => 'feather icon-circle','name' => 'Ip Restriction','route' => '/ip_restriction', 'generate_permission' => 'MANAGE_ONLY', 'show_on_sidebar' => 0])->user_roles()->sync([1,2,3]);

        MenuItem::updateOrCreate(['id'=>21],['parent_id' => 0,'order_number' => 9,'icon' => 'fa fa-circle','name' => 'Api Doc','route' => '/api_doc', 'generate_permission' => 'READ_ONLY', 'show_on_sidebar' => 1])->user_roles()->sync([2]);

        MenuItem::updateOrCreate(['id'=>22],['parent_id' => 0,'order_number' => 2,'icon' => 'feather icon-gift','name' => 'Gift Cards','route' => '/gift_cards', 'generate_permission' => 'MANAGE_ONLY', 'show_on_sidebar' => 1])->user_roles()->sync([1,2,3]);
        MenuItem::updateOrCreate(['id'=>23],['parent_id' => 22,'order_number' => 1,'icon' => 'feather icon-circle','name' => 'History','route' => '/gift_cards/history', 'generate_permission' => 'MANAGE_ONLY', 'show_on_sidebar' => 1])->user_roles()->sync([1,2,3]);
        MenuItem::updateOrCreate(['id'=>24],['parent_id' => 22,'order_number' => 2,'icon' => 'feather icon-circle','name' => 'Gift Cards','route' => '/gift_cards/gift_cards', 'generate_permission' => 'MANAGE_ONLY', 'show_on_sidebar' => 1])->user_roles()->sync([1]);
        MenuItem::updateOrCreate(['id'=>25],['parent_id' => 22,'order_number' => 0,'icon' => 'feather icon-circle','name' => 'Order Now','route' => '/gift_cards/order', 'generate_permission' => 'MANAGE_ONLY', 'show_on_sidebar' => 1])->user_roles()->sync([2,3]);


    }
}
