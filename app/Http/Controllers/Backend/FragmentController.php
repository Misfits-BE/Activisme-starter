<?php

namespace ActivismeBe\Http\Controllers\Backend;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use ActivismeBe\Http\Controllers\Controller;
use ActivismeBe\Repositories\FragmentRepository;
use ActivismeBe\Http\Requests\Backend\Fragments\UpdateValidator;
use Toastr;

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
     * @return View
     */
    public function index(): View 
    {
        return view('fragments.index', ['fragments' => $this->fragmentRepository->simplePaginate()]);
    }

    /**
     * The edit view for a page fragment in the application. 
     * 
     * @todo Build up the view
     * 
     * @param  string $slug The unique URI endpoint for the page fragment.
     * @return View
     */
    public function edit(string $slug): View 
    {
        $fragment = $this->fragmentRepository->whereSlug($slug);
        return view('fragments.edit', compact('fragment')); 
    }

    /**
     * Method for updating a page fragment in the database system 
     * 
     * @todo Implement phpunit
     * 
     * @param  UpdateValidator $input The user given input from the form.
     * @param  string          $slug  The unique identifier from the page fragment in the database. 
     * @return RedirectResponse
     */
    public function update(UpdateValidator $input, string $slug): RedirectResponse
    {
        $fragment = $this->fragmentRepository->whereSlug($slug); 
        $input->merge(['editor_id' => $input->user()->id]);

        if ($fragment->update($input->all())) {
            $langKey = 'starter-translations::fragments';

            $this->logFragmentActivity($fragment, __("{$langKey}.activity.update", ['user' => $input->user()->name, 'name' => $fragment->page])); 
            Toastr::success(__("{$langKey}.toastr.update.message", ['name' => $fragment->page]), __("{$langKey}.toastr.update.title"));
        }

        return redirect()->route('admin.fragments.index');
    }
}
