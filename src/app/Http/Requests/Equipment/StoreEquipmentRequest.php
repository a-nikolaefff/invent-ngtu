<?php

namespace app\Http\Requests\Equipment;

use App\Models\Building;
use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
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
            'number' => ['required', 'string', 'max:20', 'unique:equipment,number'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'acquisition_date' => ['nullable', 'date'],
            'decommissioning_date' => ['nullable', 'date'],
            'decommissioning_reason' => ['nullable', 'string', 'max:255'],
            'not_in_operation' => ['nullable'],
            'decommissioned' => ['nullable'],
            'equipment_type_id' => ['nullable','exists:equipment_types,id'],
            'room_id' => ['required','exists:rooms,id'],
        ];
    }
}
