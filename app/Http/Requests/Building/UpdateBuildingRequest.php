<?php

namespace app\Http\Requests\Building;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBuildingRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('buildings', 'name')->ignore(
                    $this->building->id
                ),
            ],
            'floor_amount' => ['required', 'numeric', 'gt:0'],
            'address' => [
                'required',
                'string',
                'max:255',
                Rule::unique('buildings', 'address')->ignore(
                    $this->building->id
                ),
            ],
            'building_type_id' => ['nullable', 'exists:building_types,id'],
        ];
    }
}
