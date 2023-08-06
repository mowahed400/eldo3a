<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('*************************** Start inserting admin permissions ***********************');

        config(['auth.defaults.guard' => 'admin']);

        foreach (config('permission.admin-permissions-list') as $model => $permissions)
        {
            foreach ($permissions as $permission)
            {
                Permission::firstOrCreate([
                    'name' => $permission.'-'.$model
                ]);
            }

        }

        $this->command->info('########################## Permissions was inserted successfully ##########################');

        $this->command->info('Create Super Admin Role');
        $role = Role::firstOrCreate([
            'name' => 'Super Admin',
        ]);

        $this->command->info('Super Admin Role was created');

        $role->givePermissionTo(Permission::all()->all());
    }
}
