<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Role;
use App\Permission;
use App\User;

/**
 * Class MakeRoles
 * @package App\Console\Commands
 */
class MakeRoles extends Command
{
    protected $signature = 'roles';

    protected $description = 'Generate Roles';


    public function handle() {
        $seller = Role::addRole(Role::ROLE_SELLER, 'Seller', 'User seller');
        $admin = Role::addRole(Role::ROLE_ADMIN, 'User Administrator', 'User is allowed to manage and edit other users');
        $user = Role::addRole(Role::ROLE_USER, 'User', 'User');

        $userListPerm = Permission::addPermission(Permission::PERMISSION_USER_LIST, 'User List');
        $userCreatePerm = Permission::addPermission(Permission::PERMISSION_USER_EDIT, 'User Edit');
        $userDeletePerm = Permission::addPermission(Permission::PERMISSION_USER_DELETE, 'User Edit');

        $productsListPerm = Permission::addPermission(Permission::PERMISSION_PRODUCT_LIST, 'Product List');
        $productsCreatePerm = Permission::addPermission(Permission::PERMISSION_PRODUCT_EDIT, 'Product Edit');
        $productsDeletePerm = Permission::addPermission(Permission::PERMISSION_PRODUCT_DELETE, 'Product Edit');

        $admin->attachPermission($userListPerm);
        $admin->attachPermission($userCreatePerm);
        $admin->attachPermission($userDeletePerm);
        $admin->attachPermission($productsListPerm);
        $admin->attachPermission($productsCreatePerm);
        $admin->attachPermission($productsDeletePerm);

        $seller->attachPermission($productsListPerm);
        $seller->attachPermission($productsCreatePerm);
        $seller->attachPermission($productsDeletePerm);

        $user->attachPermission($productsListPerm);

        $users = User::all();

        foreach($users as $item) {
            /** @var $item User */

            $item->attachRole($user);
        }
    }
}
