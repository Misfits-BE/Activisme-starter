<?php

namespace ActivismeBe\Traits; 

/**
 * Trait activityLog 
 * ---- 
 * Trait for internal user handling logging. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Traits
 */
trait ActivityLog
{
    /**
     * Default functiàon for adding a log in the system. 
     * 
     * @param  mixed  $entity       The entity from the instance where the event has happend on.
     * @param  string $logMessage   The log message that needs to be saved. 
     * @param  string $logName      The name for the log where the message needs to be stored. (defaults to application)
     * @return void
     */
    public function add($entity, string $logMessage, string $logName = 'application'): void 
    {
        $authUser = auth()->user();
        activity($logName)->performedOn($entity)->causedBy($authUser)->log($logMessage);
    }

    /**
     * Shorthand function for adding a log to the user section. (ACL)
     * 
     * @param  mixed  $entity   The entity form the instance where the event has happend on. 
     * @param  string $message  The log message that needs to be saved. 
     * @return void
     */
    public function logUserActivity($entity, string $message): void 
    {
        $this->add($entity, $message, 'users');
    }

    /**
     * SHorthand function for adding a log to the fragment section. 
     * 
     * @param  mixed  $entity   The entity from the instance where the event has been happend on.
     * @param  string $message  The log message that needs to be saved. 
     * @return void
     */
    public function logFragmentActivity($entity, string $message): void 
    {
        $this->add($entity, $message, 'fragments');
    }
}