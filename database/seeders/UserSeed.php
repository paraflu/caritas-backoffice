<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Permission::firstWhere('name', 'admin') ?? Permission::create(['name' => 'admin']);
        $editProduct = Permission::firstWhere('name', 'edit product') ?? Permission::create(['name' => 'edit product']);
        $deleteProduct = Permission::firstWhere('name', 'delete product') ?? Permission::create(['name' => 'delete product']);

        $deleteUser = Permission::firstWhere('name', 'delete user') ?? Permission::create(['name' => 'delete user']);
        $editUser = Permission::firstWhere('name', 'edit user') ?? Permission::create(['name' => 'edit user']);

        $user = User::firstWhere('name', 'Admin') ?? User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.it',
                'password' => Hash::make('password'),
            ]
        );

        $user->givePermissionTo($admin);
        $user->givePermissionTo(
            $editProduct,
            $deleteProduct,
            $editUser,
            $deleteUser
        );
    }
}
