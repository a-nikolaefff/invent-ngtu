<?php

namespace app\Http\Requests\Building;

use App\Models\Building;
use App\Models\DepartmentType;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowBuildingRequest extends FormRequest
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
            'floor' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $building = Building::find($this->segment(2));
                    $maxFloor = $building->floor_amount;
                    if ($value > $maxFloor) {
                        $fail("The floor must be less than or equal to $maxFloor.");
                    }
                },
            ],
            'sort' => ['nullable', Rule::in($sortableColumns)],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ];
    }
}
