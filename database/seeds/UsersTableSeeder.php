<?php

use Illuminate\Database\Seeder;
use ActivismeBe\Repositories\{UserRepository, PermissionRepository, RoleRepository};
use ActivismeBe\User;

/**
 * Class UsersTableSeeder
 * ---- 
 * General ACL database seeder. This class also covers roles and permissions. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds against the user, roles and permissions table.
     * 
     * @param  UserRepository       $users          Abstraction layer for the MySQL user table
     * @param  PermissionRepository $permissions    Abstraction layer for the MySQL permission table
     * @param  RoleRepository       $roles          Abstraction layer for the MySQL roles table
     * @return void
     */
    public function run(UserRepository $users, PermissionRepository $permissions, RoleRepository $roles): void
    {
        $this->command->info(__('starter-translations::database.permissions-added'));

        // Ask that the default roles need to be added. default = no
        if ($this->command->confirm(__('starter-translations::database.ask-roles-default'), true)) {
            $inputRoles = $this->command->ask(__('starter-translations::database.ask-roles-user'), 'admin,user'); // Ask for user specific application roles
            $arrayRoles = explode(',', $inputRoles); // Explode roles from array. BOOM! 

            foreach ($arrayRoles as $role) { // Add roles in the sys. And attach them to a created user.
                $entityRole = $roles->firstOrCreate(['name' => trim($role)]);

                if ($this->roleIsAdmin($role)) {
                    $entityRole->syncPermissions($permissions->all()); 
                    $this->command->info(__('starter-translations::database.perms-synced-admin'));
                } else { // Other default roles has by default only read access
                    $entityRole->syncPermissions($permissions->findAllBy('name', 'like', 'view_%'));
                }

                $this->createUser($role); // Create new user for each role
            } // End roles foreach loop

            $this->command->info(__('starter-translations::database.role-created-info', ['roles' => $inputRoles]));
        } else { //: Implement only the default user role
            if ($roles->entity()->where('name', 'user')->count() > 0) { // Check if the role doesn't exist already in the database
                // Role doesn't exist in the database so add the role.
                $roles->create(['name' => 'user']);
                $this->command->info(__('starter-translations::database.only-default-role-added'));
            } else { // Role exists already
                $this->command->error(__('starter-translations::database.no-roles-added'));
            }
        }
    }

    /**
     * Check of the given role is name 'admin'
     * 
     * @param  string $role The role name form the freshly created role in the database
     * @return bool 
     */
    private function roleIsAdmin(string $role): bool 
    {
        return $role === 'admin';
    }

    /**
     * Function for creating a dummy login for each role in the database. 
     * 
     * @param  string $role The name from the role that is created in the database
     * @return void
     */
    private function createUser(string $role): void 
    {
        $user = factory(User::class)->create(['password' => 'secret'])->assignRole($role);

        if ($this->roleIsAdmin($role)) {
            $this->command->info(__('starter-translations::database.user-admin-role'));
            $this->command->warn($user->email); 
            $this->command->warn(__('starter-translations::database.default-password'));
        }
    }
}
