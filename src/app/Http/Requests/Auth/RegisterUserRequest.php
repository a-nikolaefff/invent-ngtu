<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public static $rules
        = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:'.User::class
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department_id' => ['exists:departments,id'],
            'post' => ['required', 'string', 'max:255'],
            'g-recaptcha-response' => 'required|captcha'
        ];


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
        return self::$rules;
    }
}
