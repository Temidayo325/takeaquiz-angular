<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class CreateTicketRequest extends FormRequest
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
            'event_id' => ['required', 'exists:events,id', 'integer', 'bail'],
            'price' => ['required', 'integer', 'bail'],
            'total_seat' => ['required', 'integer', 'bail'],
            'ticket_type' => ['required','string', 'bail'],
            'type_copy' => ['required', 'string', 'bail'],
            'access_type' => ['required', 'in:Purchase,Gift', 'string', 'bail']
        ];
    }
}