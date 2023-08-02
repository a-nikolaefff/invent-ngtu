<?php

namespace app\Http\Requests\Images;

use App\Models\Building;
use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,gif|max:10240',
        ];
    }
}
