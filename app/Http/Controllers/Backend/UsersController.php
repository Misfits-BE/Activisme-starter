<?php

namespace ActivismeBe\Http\Controllers\Backend;

use Illuminate\View\View;
use ActivismeBe\Http\Controllers\Controller;
use ActivismeBe\Repositories\UserRepository;

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
}
