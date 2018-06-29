<?php

namespace ActivismeBe\Http\Controllers\Frontend;

use Illuminate\View\View;
use ActivismeBe\Http\Controllers\Controller;
use ActivismeBe\Repositories\FragmentRepository;

/**
 * Class PolicyController
 * ---- 
 * Controller for our policy pages like the Terms of service and privacy policy. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Http\Controllers\Frontend
 */
class PolicyController extends Controller
{
    /** #var FragmentsRepository $fragmentsRepository The variable for the abstraction layer. */
    private $fragmentRepository; 

    /**
     * PolicyController constructor 
     * 
     * @param  FragmentRepository $fragmentRepository The abstraction layer for the fragments between controller and db. 
     * @return void 
     */
    public function __construct(FragmentRepository $fragmentRepository)
    {
        $this->fragmentRepository = $fragmentRepository;
    }

    /**
     * Get the privacy policy page in the application. 
     * 
     * @todo Implement phpunit
     * 
     * @return View
     */
    public function privacy(): View 
    {
        $pageData = $this->fragmentRepository->getPage('Privacy Policy');
        return view('policy.page', compact('pageData'));
    }

    /**
     * Get the terms of service policy page for the application. 
     * 
     * @todo Implement route
     * 
     * @return View 
     */
    public function termsOfService(): View 
    {
        $pageData = $this->fragmentRepository->getPage('Terms Of Service');
        return view('policy.page', compact('pageData'));
    }
}
