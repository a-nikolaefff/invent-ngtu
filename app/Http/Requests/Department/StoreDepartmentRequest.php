<?php

namespace app\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:departments,name'],
            'short_name' => ['nullable', 'string', 'max:50', 'unique:departments,short_name'],
            'department_type_id' => ['nullable', 'exists:department_types,id'],
            'parent_department_id' => ['nullable', 'exists:departments,id'],
        ];
    }
}
