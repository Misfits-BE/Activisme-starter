<?php

namespace ActivismeBe\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class UserRegistered 
 * ----
 * The mail notification to send the password to the created user entity. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Notifications
 */
class UserRegistered extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The variable for the create user (database entity)
     * 
     * @var User $user
     */
    public $user; 

    /**
     * The variable for the password out of the observer. 
     * 
     * @var string $password
     */
    public $password;

    /**
     * Create a new notification instance.
     *
     * @param  User   $user
     * @param  string $password
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->password = $password; 
        $this->user     = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable The notification builder instance.
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable The notification builder instance
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        $transKey = 'starter-translations::users.register-mail'; 

        return (new MailMessage)
            ->subject(__("{$transKey}.title", ['application' => config('app.name')]))
            ->greeting(__("{$transKey}.greeting", ['user' => $this->user->name]))
            ->line(__("{$transKey}.first-paragraph", ['application' => config('app.name')]))
            ->line(__("{$transKey}.second-paragraph", ['password' => $this->password]))
            ->action(__("{$transKey}.button"), config('app.url'));
    }
}
