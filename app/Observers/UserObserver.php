<?php

namespace ActivismeBe\Observers;

use ActivismeBe\User;
use ActivismeBe\Notifications\UserRegistered;

/**
 * Class UserObserver 
 * ----
 * Observer for all the User model related Eloquent events 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Observers
 */
class UserObserver
{
    /**
     * Handle to the user "created" event.
     *
     * @param  \ActivismeBe\User  $user The database entity form the created user.
     * @return void
     */
    public function created(User $user): void
    {
        if (auth()->check()) {
            $password = str_random(20);

            if ($user->update(['password' => $password])) {
                $when = now()->addMinute(); 
                $user->notify((new UserRegistered($user, $password))->delay($when));
            }
        }
    }
}
