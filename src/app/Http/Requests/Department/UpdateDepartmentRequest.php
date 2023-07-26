<?php

namespace app\Http\Requests\Department;

use App\Rules\NotSameAsCurrentDepartment;
use App\Rules\NotSelfParent;
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
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:50'],
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
