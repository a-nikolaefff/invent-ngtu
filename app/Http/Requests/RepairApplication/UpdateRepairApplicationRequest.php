<?php

namespace app\Http\Requests\RepairApplication;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepairApplicationRequest extends FormRequest
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
            'response' => ['nullable', 'string', 'max:255'],
            'repair_application_status_id' => [
                'required',
                'exists:repair_application_statuses,id',
            ],
        ];
    }
}
