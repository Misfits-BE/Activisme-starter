<?php 

namespace ActivismeBe\Repositories;

use ActivismeBe\User;
use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;
use Illuminate\Pagination\Paginator;

/**
 * Class UserRepository
 * ----
 * Repository for all the logic that needs for user handlings between database
 * and other parts in the application. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Repositories
 */
class UserRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }

    /**
     * Get all the users based on the given ACl permission role
     * 
     * @param  string $name The name for the ACL permission role.
     * @return Paginator
     */
    public function getUsersRole(string $name): Paginator
    {
        return $this->model->role($name)->simplePaginate();
    }
}