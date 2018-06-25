<?php

namespace ActivismeBe\Http\Requests\Backend\Users;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateValidator
 * ----
 * Form request class that handles the validation when an admin tries to add a new user (login)
 * in the application.
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT license>
 * @package     ActivismeBe\Http\Requests\Backend\Users
 */
class CreateValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'firstname' => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
        ];
    }
}
