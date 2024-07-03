<?php

namespace app\Http\Requests\Equipment;

use App\Models\RepairStatus;
use App\Models\RepairType;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowEquipmentRequest extends FormRequest
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
            'short_description',
            'start_date',
            'end_date',
            'repair_type_name',
            'repair_status_id',
        ];

        return [
            'repair_type_id' => [
                'nullable',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (! RepairType::where('id', $value)->exists()) {
                        if ($value !== 'none') {
                            $fail(
                                __('validation.invalid', ['attribute' => __('validation.attributes.'.$attribute)])
                            );
                        }
                    }
                },
            ],
            'repair_status_id' => [
                'nullable',
                'string',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (! RepairStatus::where('id', $value)->exists()) {
                        if ($value !== 'none') {
                            $fail(
                                __('validation.invalid', ['attribute' => __('validation.attributes.'.$attribute)])
                            );
                        }
                    }
                },
            ],
            'sort' => ['nullable', Rule::in($sortableColumns)],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ];
    }
}
