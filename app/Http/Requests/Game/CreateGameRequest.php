<?php

namespace App\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class CreateGameRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:games,name', 'bail'], 
            'summary' => ['required', 'string', 'min:3', 'bail'], 
            'stepByStep' => ['required', 'string', 'min:10'], 
            'minimum_player' => ['required', 'min:1', 'integer', 'bail'], 
            'maximum_player' => ['required', 'min:1', 'integer', 'bail'], 
            'image' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048']
        ];
    }
}
