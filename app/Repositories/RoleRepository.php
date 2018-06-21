<?php 

namespace ActivismeBe\Repositories;

use Spatie\Permission\Models\Role;
use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;

/**
 * Class RoleRepository
 * ----
 * Repository for all the logic that needs for ACL role handlings between database
 * and other parts in the application. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Repositories
 */
class RoleRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model(): string
    {
        return Role::class;
    }

    /**
     * Create a new ACL role in the application. When the given data is not found. 
     * 
     * @param array $role The given data that needs to be checked or inserted 
     *                    When no matched data is found in the database. 
     * 
     * @return Role
     */
    public function firstOrCreate(array $role): Role 
    {
       return $this->model->firstOrCreate($role); 
    }
}