<?php

namespace app\Http\Requests\RepairApplication;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepairApplicationRequest extends FormRequest
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
            'short_description' => ['required', 'string', 'max:50'],
            'full_description' => ['nullable', 'string', 'max:555'],
            'equipment_id' => ['required','exists:equipment,id'],
        ];
    }
}
