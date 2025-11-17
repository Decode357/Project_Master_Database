<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('controller.validation.name.required'),
            'name.max' => __('controller.validation.name.max'),
            'email.required' => __('controller.validation.email.required'),
            'email.email' => __('controller.validation.email.email'),
            'email.unique' => __('controller.validation.email.unique'),
            'email.max' => __('controller.validation.email.max', ['max' => 255]),
        ];
    }
}
