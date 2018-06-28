<?php

namespace ActivismeBe\Http\Controllers\Backend;

use Illuminate\View\View;
use ActivismeBe\Http\Controllers\Controller;
use ActivismeBe\Repositories\FragmentRepository;

/**
 * Class FragmentController
 * ----- 
 * Management controller for the page fragments in the application. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT License>
 * @package     ActivismeBe\Http\Controllers\Backend
 */
class FragmentController extends Controller
{
    /** @var FragmentRepository The variable for the database page fragment entity. */
    private $fragmentRepository; 

    /**
     * FragmentController Constructor 
     * 
     * @param  FragmentRepository $fragmentRepository The abstraction layer between database and controller.
     * @return void
     */
    public function __construct(FragmentRepository $fragmentRepository) 
    {
        $this->middleware(['auth', 'role:admin']);
        $this->fragmentRepository = $fragmentRepository;
    }

    /**
     * Get the management index view for the page fragments.
     * 
     * @todo Implement phpunit test
     * 
     * @return View
     */
    public function index(): View 
    {
        return view('fragments.index', ['fragments' => $this->fragmentRepository->simplePaginate()]);
    }
}
