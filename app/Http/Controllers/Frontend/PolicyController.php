<?php

namespace ActivismeBe\Http\Controllers\Frontend;

use Illuminate\View\View;
use ActivismeBe\Http\Controllers\Controller;

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
    /**
     * PolicyController constructor 
     * 
     * @todo Implement repository for the fragments in the database. 
     * 
     * @return void 
     */
    public function __construct()
    {
        // 
    }

    /**
     * Get the privacy policy page in the application. 
     * 
     * @return View
     */
    public function privacy(): View 
    {
        return view('policy.privacy');
    }
}
