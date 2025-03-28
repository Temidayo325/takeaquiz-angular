<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'bail'],
            'event_date' => ['required', 'date', 'bail'],
            'starting_time' => ['required', 'string', 'bail'],
            'state' => ['required', 'string', 'bail'],
            'coordinate' => ['nullable', 'string', 'bail'],
            'location' => ['required', 'string', 'bail'],
            'flier' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
            'promotional_copy' => ['required', 'string', 'bail'],
            'id' => ['integer', 'min:1', 'nullable'],
            'duration' => ['required', 'string', 'bail'],
            'audience' => ['nullable', 'string', 'bail'],
            'dress_code' => ['nullable', 'string', 'bail'],
            'contact_information' => ['required', 'string', 'bail'],
            'ticket_information' => ['nullable', 'string'],
            'coordinate' => ['nullable', 'string']
        ];
    }
}
