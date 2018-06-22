<?php 

namespace Tests;

use ActivismeBe\User;
use Spatie\Permission\Models\Role;

/**
 * Trait CreatesUsers
 * ----- 
 * This trait has the function of creating dummy users in the testing from 
 * this application. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     Tests
 */
trait CreatesUsers
{
    /**
     * Internal function for creating the needed role in the database. 
     * 
     * @param  string $name The name for the needed role in the testing system.
     * @return Role
     */
    private function createRole(string $name): Role
    {
        return factory(Role::class)->create(['name' => $name]);
    }

    /**
     * Create the needed user in the testing application. 
     * 
     * @param  string $role The name for the needed role that needs to be attached to the user.
     * @return User
     */
    public function createUser(string $role): User 
    {
        $role = $this->createRole($role);
        return factory(User::class)->create()->assignRole($role->name);
    }
}