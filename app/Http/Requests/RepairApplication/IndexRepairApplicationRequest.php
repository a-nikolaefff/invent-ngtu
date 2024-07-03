<?php

namespace app\Http\Requests\RepairApplication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRepairApplicationRequest extends FormRequest
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
            'id',
            'short_description',
            'application_date',
            'response_date',
            'equipment_name',
            'repair_application_status_id',
            'user_name',
        ];

        return [
            'repair_application_status_id' => [
                'nullable',
                'string',
                'exists:repair_application_statuses,id',
            ],
            'search' => ['nullable', 'string'],
            'sort' => ['nullable', Rule::in($sortableColumns)],
            'direction' => ['nullable', Rule::in(['asc', 'desc'])],
        ];
    }
}
