<?php

namespace app\Http\Requests\Equipment;

use App\Models\Building;
use App\Models\DepartmentType;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexEquipmentRequest extends FormRequest
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
        $sortableColumns = [
            'number',
            'name',
            'equipment_type_name',
            'location',
            'department_name'
        ];

        return [
            'equipment_type_id' => [
                'nullable',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!DepartmentType::where('id', $value)->exists()) {
                        if ($value !== 'none') {
                            $fail(
                                __('validation.invalid', ['attribute' => __('validation.attributes.' . $attribute)])
                            );
                        }
                    }
                },
            ],
            'search' => ['nullable', 'string'],
            'not_in_operation' => ['nullable', 'string'],
            'decommissioned' => ['nullable', 'string'],
            'sort' => ['nullable', Rule::in($sortableColumns)],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ];
    }
}
