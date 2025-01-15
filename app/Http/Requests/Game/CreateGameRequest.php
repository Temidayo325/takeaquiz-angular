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
            'stepByStepJson' => ['required', 'string'], 
            'minimum_player' => ['required', 'min:1', 'integer', 'bail'], 
            'maximum_player' => ['required', 'min:1', 'string', 'bail'], 
            'picture' => ['nullable', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
            'materials' => ['required', 'string', 'min:10'], 
            'play_time' => ['required', 'string', 'min:10'], 
            'difficulty_level' => ['required', 'string'], 
            'category' => ['required', 'string'], 
            'ideal_setting' => ['required', 'string'], 
            'objective' => ['required', 'string', 'min:10'], 
            'tips' => ['required', 'string', 'min:10']
        ];
    }
}
