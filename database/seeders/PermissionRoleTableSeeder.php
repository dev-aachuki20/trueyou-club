<?php
namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $all_permissions = Permission::all();

        $superAdminPermissions = $all_permissions->filter(function ($permission) {
            return $permission;
        });
       
        Role::findOrFail(1)->permissions()->sync($superAdminPermissions->pluck('id'));

        $userPermissions = $all_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 11) != 'permission_' && substr($permission->title, 0, 5) != 'role_'  && substr($permission->title, 0, 8) != 'setting_' && substr($permission->title, 0, 12) != 'transaction_' && substr($permission->title, 0, 5) != 'user_';
        });
        
        Role::findOrFail(2)->permissions()->sync($userPermissions);
    }
}
