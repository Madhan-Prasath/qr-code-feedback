<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view-permissions',     'guard_name' => 'web']);
        Permission::create(['name' => 'viewAny-permissions',  'guard_name' => 'web']);
        Permission::create(['name' => 'create-permissions',   'guard_name' => 'web']);
        Permission::create(['name' => 'edit-permissions',     'guard_name' => 'web']);
        Permission::create(['name' => 'delete-permissions',   'guard_name' => 'web']);

        Permission::create(['name' => 'view-roles',       'guard_name' => 'web']);
        Permission::create(['name' => 'viewAny-roles',    'guard_name' => 'web']);
        Permission::create(['name' => 'create-roles',     'guard_name' => 'web']);
        Permission::create(['name' => 'edit-roles',       'guard_name' => 'web']);
        Permission::create(['name' => 'delete-roles',     'guard_name' => 'web']);

        Permission::create(['name' => 'view assets',      'guard_name' => 'web']);
        Permission::create(['name' => 'viewAny assets',   'guard_name' => 'web']);
        Permission::create(['name' => 'create assets',    'guard_name' => 'web']);
        Permission::create(['name' => 'edit assets',      'guard_name' => 'web']);
        Permission::create(['name' => 'delete assets',    'guard_name' => 'web']);

        Permission::create(['name' => 'view reports',     'guard_name' => 'web']);
        Permission::create(['name' => 'viewAny reports',  'guard_name' => 'web']);
        Permission::create(['name' => 'create reports',   'guard_name' => 'web']);
        Permission::create(['name' => 'edit reports',     'guard_name' => 'web']);
        Permission::create(['name' => 'delete reports',   'guard_name' => 'web']);

        Permission::create(['name' => 'view users',       'guard_name' => 'web']);
        Permission::create(['name' => 'viewAny users',    'guard_name' => 'web']);
        Permission::create(['name' => 'create users',     'guard_name' => 'web']);
        Permission::create(['name' => 'edit users',       'guard_name' => 'web']);
        Permission::create(['name' => 'delete users',     'guard_name' => 'web']);

        Permission::create(['name' => 'viewAny user_activity_logs',   'guard_name' => 'web']);

        Permission::create(['name' => 'viewAny activity_logs',   'guard_name' => 'web']);

        // create User role with default permissions
        $user = Role::create(['name' => 'User']);

        $user->givePermissionTo(['create reports']);

        $this->command->info('Permissions granted User');

        // create Admin role with default permissions
        $role = Role::create(['name' => 'Admin']);

        $role->givePermissionTo(['view-roles',
                                 'viewAny-roles',
                                 'create-roles',
                                 'edit-roles',
                                 'delete-roles',
                                 'view-permissions',
                                 'viewAny-permissions',
                                 'create-permissions',
                                 'edit-permissions',
                                 'delete-permissions',
                                 'view assets',
                                 'viewAny assets',
                                 'create assets',
                                 'edit assets',
                                 'delete assets',
                                 'view reports',
                                 'viewAny reports',
                                 'create reports',
                                 'edit reports',
                                 'delete reports',
                                 'view users',
                                 'viewAny users',
                                 'create users',
                                 'edit users',
                                 'delete users',
                                 'viewAny user_activity_logs',
                                 'viewAny activity_logs'
                                ]);

        $this->command->info('Permissions granted Admin');

        $user = User::create([
            'name'      => env('SUPER_ADMIN_NAME'),
            'email'     => env('SUPER_ADMIN_EMAIL'),
            'password'  => Hash::make(env('SUPER_ADMIN_PASSWORD'))
        ]);

        // Grant Super Admin rights to SUPER_ADMIN_EMAIL
        $adminEmail = env('SUPER_ADMIN_EMAIL', null);
        if (is_null($adminEmail)) {
            throw new \InvalidArgumentException('SUPER_ADMIN_EMAIL cannot be empty!');
        }

        $user = User::whereEmail($adminEmail)->first();
        if (is_null($user)) {
            throw new \InvalidArgumentException('User cannot be empty!');
        }

        $role = Role::create(['name' => 'Super Admin']);
        $user->assignRole('Super Admin');
        $this->command->info('Super Admin Role created successfully.');
    }
}
