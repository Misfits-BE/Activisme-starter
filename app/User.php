<?php

namespace ActivismeBe;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 * ----- 
 * Database model for the users (logins) table in the database. 
 * 
 * @author      Tim Joosten <tim@activisme.be> 
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe
 */
class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
