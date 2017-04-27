<?php

use App\Group;
use App\Permission;
use App\Role;
use App\Service;
use App\ServiceUrl;
use App\User;
use App\UserHistory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['user:index', 'List all users'],
            ['user:show', 'View user details'],
            ['user:create', 'Create new user'],
            ['user:update', 'Update existing user'],
            ['user:delete', 'Delete existing user'],
            ['user:restore', 'Restore deleted user'],
            ['user:revisions', 'View user revisions'],
            ['user:histories', 'View user histories'],
            ['user:archives', 'List deleted users'],
            ['user:duplicate', 'Duplicate existing user'],
            
            ['user:activate', 'Activate a user'],
            ['user:suspend', 'Suspend a user'],

            ['role:index', 'List all roles'],
            ['role:show', 'View role details'],
            ['role:create', 'Create new role'],
            ['role:update', 'Update existing role'],
            ['role:delete', 'Delete existing role'],
            ['role:restore', 'Restore deleted role'],
            ['role:revisions', 'View role revisions'],
            ['role:histories', 'View role histories'],
            ['role:archives', 'List deleted roles'],
            ['role:duplicate', 'Duplicate existing role'],

            ['permission:index', 'List all permissions'],
            ['permission:show', 'View permission details'],
            ['permission:create', 'Create new permission'],
            ['permission:update', 'Update existing permission'],
            ['permission:delete', 'Delete existing permission'],
            ['permission:restore', 'Restore deleted permission'],
            ['permission:revisions', 'View all permission revisions'],
            ['permission:histories', 'View all permissions'],
            ['permission:archives', 'List delete permissions'],
            ['permission:duplicate', 'Duplicate existing permission'],

            ['group:index', 'List all groups'],
            ['group:show', 'View group details'],
            ['group:create', 'Create new group'],
            ['group:update', 'Update existing group'],
            ['group:delete', 'Delete existing group'],
            ['group:restore', 'Restore deleted group'],
            ['group:revisions', 'View all group revisions'],
            ['group:histories', 'View all groups'],
            ['group:archives', 'List delete groups'],
            ['group:duplicate', 'Duplicate existing group'],

            ['service:index', 'List all services'],
            ['service:show', 'View service details'],
            ['service:create', 'Create new service'],
            ['service:update', 'Update existing service'],
            ['service:delete', 'Delete existing service'],
            ['service:restore', 'Restore deleted service'],
            ['service:revisions', 'View all service revisions'],
            ['service:histories', 'View all services'],
            ['service:archives', 'List delete services'],
            ['service:duplicate', 'Duplicate existing service']
        ];

        foreach($permissions as $permission)
        {
            Permission::create(['name' => $permission[0], 'description' => $permission[1]]);
        }

        $admin = Role::create(['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Has access to everything']);
        $admin->permissions()->sync(Permission::pluck('id')->toArray());

        Role::create(['name' => 'user', 'display_name' => 'User', 'description' => 'Normal user']);

        $groups = [
            ['admin', 'Admin', 'All admin users'],
            ['user', 'User', 'All users'],
        ];

        foreach ($groups as $group)
        {
            Group::create(['name' => $group[0], 'display_name' => $group[1], 'description' => $group[2]]);
        }

        $internal = Service::create([
            'name' => 'PHP CAS Server',
            'status' => 'active'
        ]);
        $internal->urls()->save(new ServiceUrl([
            'url' => url('login')
        ]));

        $user = new User([
            'username' => 'administrator',
            'email' => 'phpcasserver@muxplatform.com',
            'name' => 'Administrator',
            'password' => bcrypt('password'),
        ]);
        $user->confirmation_token = str_random(100);
        $user->save();
        $user->roles()->attach($admin);
        $user->groups()->sync(Group::pluck('id')->toArray());
        $user->histories()->save(new UserHistory([
            'action' => 'create',
            'remarks' => 'Created from Seeder'
        ]));
    }
}
