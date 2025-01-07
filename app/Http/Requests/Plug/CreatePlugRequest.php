<?php

namespace App\Http\Requests\Plug;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlugRequest extends FormRequest
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
            'state' => ['required', 'string', 'bail'],
            'tags' => ['required', 'string', 'bail'],
            'address' => ['required', 'string', 'bail'],
            'travel' => ['required', 'string', 'bail'],
            'flier' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048',    'bail'],
            'service' => ['required', 'string', 'bail'],
            'service_summary' => ['required', 'string', 'bail'],
            'usp' => ['required', 'string', 'bail'],
            'social_media_links' => ['required', 'string', 'bail']
        ];
    }
}
