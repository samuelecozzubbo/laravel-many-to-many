<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'collaborators' => 'required|integer|min:1',
            'img' => 'nullable|url'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.max' => 'Il titolo non può superare i 100 caratteri.',
            'description.required' => 'La descrizione è obbligatoria.',
            'start_date.required' => 'La data di inizio è obbligatoria.',
            'end_date.required' => 'La data di fine è obbligatoria.',
            'end_date.after_or_equal' => 'La data di fine deve essere uguale o successiva alla data di inizio.',
            'collaborators.required' => 'Il numero di collaboratori è obbligatorio.',
            'collaborators.integer' => 'Il numero di collaboratori deve essere un numero intero.',
            'collaborators.min' => 'Il numero minimo di collaboratori è 1.',
            'img.url' => 'Il campo immagine deve essere un URL valido.'
        ];
    }
}
