<?php 

namespace ActivismeBe\Repositories;

use ActivismeBe\Models\Fragments;
use ActivismeBE\DatabaseLayering\Repositories\Contracts\RepositoryInterface;
use ActivismeBE\DatabaseLayering\Repositories\Eloquent\Repository;

/**
 * Class FragmentRepository
 *
 * @package ActivismeBe\Repositories
 */
class FragmentRepository extends Repository
{
    /**
     * Set the eloquent model class for the repository.
     *
     * @return string
     */
    public function model(): string
    {
        return Fragments::class;
    }
}