<?php

namespace ActivismeBe\Observers;

use ActivismeBe\User;

/**
 * Class UserObserver 
 * ----
 * Observer for all the User model related Eloquent events 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Observers
 */
class UserObserver extends BaseConstructor
{
    /**
     * Handle to the user "created" event.
     *
     * @param  \ActivismeBe\User  $user The database entity form the created user.
     * @return void
     */
    public function created(User $user): void
    {
        $password = str_random(20);

        if (auth()->check()) {
            if ($user->update(['password' => $password])) {
                $when = now()->addMinute(); 
                
            }
        }
    }
}
