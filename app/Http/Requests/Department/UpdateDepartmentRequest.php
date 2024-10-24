<?php

namespace app\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
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
        $departmentId = $this->route('department')->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'name')
                    ->ignore($this->department->id),
            ],
            'short_name' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('departments', 'short_name')
                    ->ignore($this->department->id),
            ],
            'department_type_id' => ['nullable', 'exists:department_types,id'],
            'parent_department_id' => [
                'nullable',
                'exists:departments,id',
                function ($attribute, $value, $fail) use ($departmentId) {
                    if ($value == $departmentId) {
                        $fail('validation.not_self_parent')->translate();
                    }
                },
            ],
        ];
    }
}
