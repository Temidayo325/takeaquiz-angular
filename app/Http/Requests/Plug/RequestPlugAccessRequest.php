<?php

namespace App\Http\Requests\Plug;

use Illuminate\Foundation\Http\FormRequest;

class RequestPlugAccessRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'service' => ['required', 'string', 'min:2','bail'],
            'service_summary' => ['required', 'min:20', 'string', 'bail'],
        ];
    }
}
