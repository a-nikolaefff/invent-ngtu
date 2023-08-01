<?php

namespace app\Http\Requests\Room;

use App\Models\Building;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'number' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
            'building_id' => ['required','exists:buildings,id'],
            'floor' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $building = Building::findOrFail($this->input('building_id'));
                    $maxFloor = $building->floor_amount;

                    if ($value > $maxFloor) {
                        $fail("The floor must be less than or equal to $maxFloor.");
                    }
                },
            ],
            'room_type_id' => ['nullable','exists:room_types,id'],
            'department_id' => ['nullable','exists:departments,id'],
        ];
    }
}
