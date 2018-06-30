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

    /**
     * Get a page fragment based on the page name. 
     * 
     * @param  string $slug Get a page fragment based on the page type. 
     * @return Fragments
     */
    public function getPage(string $pageName): Fragments
    {
        return $this->model->where('page', $pageName)->firstOrFail();
    }

    /**
     * Get a page fragment for update based on their slug
     * 
     * @param  string $slug The unique URI endpoint for the page fragment 
     * @return Fragments
     */
    public function whereSlug(string $slug): Fragments 
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }
}