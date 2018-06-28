<?php

namespace ActivismeBe\Models;

use ActivismeBe\User;
use Illuminate\Database\Eloquent\{Relations\BelongsTo, Model};

/**
 * Class Fragments 
 * ----- 
 * Database model for page fragments like the policy pages. 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT License>
 * @package     ActivismeBe\Models
 */
class Fragments extends Model
{
    /**
     * Mass-assign fields for the database fields.
     * 
     * @return array
     */
    protected $fillable = ['slug', 'page', 'title', 'content'];

    /**
     * The relation for the user data form the last editor of the page fragment
     * 
     * @return BelongsTo
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'editor_id')
            ->withDefault(['name' => __('starter-translations::fragments.table.editor-unknown')]);
    }
}
