<?php
namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $updateDate = $createDate = date('Y-m-d H:i:s');
        $permissions = [
            [
                'title'      => 'permission_create',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'permission_edit',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'permission_show',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'permission_delete',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'permission_access',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'role_create',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'role_edit',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'role_show',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'role_delete',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'role_access',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'user_management_access',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'user_create',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [   
                'title'      => 'user_edit',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'user_show',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'user_delete',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'title'      => 'user_access',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            
            
            [
                'title'      => 'setting_access',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
          
            [
                'title'      => 'transaction_access',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

        ];

        Permission::insert($permissions);

    }
}
