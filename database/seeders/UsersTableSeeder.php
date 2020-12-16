<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \OTIFSolutions\ACLMenu\Models\UserRole;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::find(1) === null)
            User::Create(
                [
                    'id' => 1,
                    'name' => 'Administrator',
                    'email' => 'admin@system.com',
                    'password' => Hash::make('admin'),
                    'username' => 'administrator',
                    'user_role_id' => UserRole::where('name','ADMIN')->first()['id']
                ]
            );
    }
}
