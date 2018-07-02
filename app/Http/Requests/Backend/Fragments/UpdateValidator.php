<?php

namespace ActivismeBe\Http\Requests\Backend\Fragments;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateValidator
 * ----
 * Form request clpass for validating the update data for a page fragment 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   Tim Joosten <MIT License>
 * @package     ActivismeBe\Http\Requests\Backend\Fragments
 */
class UpdateValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'   => 'required|string|max:200', 
            'content' => 'required|string'
        ];
    }
}
