<?php

namespace app\Http\Requests\Repair;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepairRequest extends FormRequest
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
            'short_description' => ['required', 'string', 'max:125'],
            'full_description' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'equipment_id' => ['required', 'exists:equipment,id'],
            'repair_type_id' => ['nullable', 'exists:repair_types,id'],
            'repair_status_id' => ['nullable', 'exists:repair_statuses,id'],
        ];
    }
}
