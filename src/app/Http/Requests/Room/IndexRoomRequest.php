<?php

namespace app\Http\Requests\Room;

use App\Models\DepartmentType;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRoomRequest extends FormRequest
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
            'name',
            'number',
            'room_type_name',
            'department_name',
            'building_name',
        ];

        return [
            'room_type_id' => [
                'nullable',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!DepartmentType::where('id', $value)->exists()) {
                        if ($value !== 'none') {
                            $fail("The {$attribute} is invalid.");
                        }
                    }
                },
            ],
            'building_id' => ['exists:buildings,id'],
            'search' => ['nullable', 'string'],
            'sort' => ['nullable', Rule::in($sortableColumns)],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ];
    }
}
