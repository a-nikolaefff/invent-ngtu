<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'role_id' => [
                'nullable',
                'integer',
                'exists:user_roles,id',
            ],
            'department_id' => ['nullable', 'exists:departments,id'],
            'post' => ['required', 'string', 'max:255'],
        ];
    }
}
