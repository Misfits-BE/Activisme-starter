<?php

namespace ActivismeBe\Http\Controllers\Backend;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use ActivismeBe\Http\Controllers\Controller;
use ActivismeBe\Repositories\UserRepository;
use ActivismeBe\Http\Requests\Backend\Users\CreateValidator;
use Toastr;

/**
 * Class UsersController
 * ----
 * Controller that handles all the user (logins) related stuff in some 
 * application. That is build with this starter template
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Http\Controllers\Backend
 */
class UsersController extends Controller
{
    /** @var UserRepository $users The variable for the abstraction layer bewteen users table and controller */
    private $users; 

    /**
     * UsersController Constructor 
     * 
     * @param  UsersRepository $users The actual abstraction layer for the users between database and controller
     * @return void
     */
    public function __construct(UserRepository $users) 
    {
        $this->middleware(['auth', 'role:admin']);
        $this->users = $users;
    }

    /**
     * Get the overview listing form the users. 
     * 
     * @return View
     */
    public function index(): View 
    {
        return view('users.index', ['users' => $this->users->getUsersRole('user')]);
    }

    /**
     * Display the create view for a new login in the application. 
     * 
     * @return View
     */
    public function create(): View 
    {
        return view('users.create');
    }

    /**
     * Store a new user in the application. 
     * 
     * @param  CreateValidator $input The form request class that validate the user input.
     * @return RedirectResponse
     */
    public function store(CreateValidator $input): RedirectResponse 
    {
        $input->merge(['name' => "{$input->firstname} {$input->lastname}"]); 

        if ($user = $this->users->create($input->all())) { // User is declared to variable and saved in database
            Toastr::success(__('starter-translations::users.toastr.store.title'), __('starter-translations::users.toastr.store.message'));
            $this->logUserActivity($user, __('starter-translations::users.activity.store', ['name' => $user->name]));
        }

        return redirect()->route('admin.users.index');
    }
}
