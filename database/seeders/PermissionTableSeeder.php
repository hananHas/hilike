<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'analytics-list',
            'filters-management',
            'settings-management',
            'gifts-management',
            'coins-management',
            'notifications-create',
            'app-links-edit',
            'users-management',
            'report-list',
            'chats-monitoring',
            'preview-images',
            'preview-texts',
            'chat-support',
            'contact-messages',
            'plans-management',
            'subscriptions-list',
            'roles-management',
            'admins-management',

         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
