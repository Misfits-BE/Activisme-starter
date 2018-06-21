<?php 

namespace ActivismeBe\Repositories;

use Spatie\Permission\Models\Permission;
use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;

/**
 * Class PermissionRepository
 * ----
 * Repository for all the logic that needs for ACL permission handlings between database
 * and other parts in the application. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Repositories
 */
class PermissionRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model(): string
    {
        return Permission::class;
    }
}