<?php

namespace app\Http\Requests\Room;

use App\Models\Building;
use App\Models\Room;
use App\Validator\GeometryValidator;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'number' => ['required', 'string', 'max:20', function (string $attribute, mixed $value, Closure $fail) {
                $buildingId = $this->request->get('building_id');
                $isEngagedNumber = Room::where('building_id', $buildingId)
                    ->where('number', $value)
                    ->exists();
                if ($isEngagedNumber) {
                    $fail(
                        __('validation.unique', ['attribute' => __('validation.attributes.'.$attribute)])
                    );
                }
            }, ],
            'name' => ['required', 'string', 'max:255'],
            'building_id' => ['required', 'exists:buildings,id'],
            'floor' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    $building = Building::findOrFail($this->input('building_id'));
                    $maxFloor = $building->floor_amount;
                    if ($value > $maxFloor) {
                        $fail(
                            __('validation.max.numeric', [
                                'attribute' => __('validation.attributes.'.$attribute),
                                'max' => $maxFloor,
                            ])
                        );
                    }
                },
            ],
            'room_type_id' => ['nullable', 'exists:room_types,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $geometryValidator = app(GeometryValidator::class);
        $geometryValidator->applyRules($validator, $this->input('geometry.anchor_point'));
    }
}
