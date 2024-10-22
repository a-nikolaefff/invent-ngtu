<?php

namespace app\Http\Requests\Building;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuildingRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:buildings,name'],
            'floor_amount' => ['required', 'numeric', 'gt:0'],
            'address' => ['required', 'string', 'max:255', 'unique:buildings,address'],
            'building_type_id' => ['nullable', 'exists:building_types,id'],
            'model' => ['nullable', 'file', 'extensions:obj,gltf,glb,fbx'],
            'model_scale' => 'nullable'
        ];
    }
}
