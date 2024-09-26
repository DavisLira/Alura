<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeriesFormRequest extends FormRequest
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
            'name' => ['required', 'min:3'],
            'cover' => Rule::when($this->method() === 'POST', ['image', 'max: 500']), // mínimo de 500kb
            'seasonsQty' => Rule::when($this->method() === 'POST', ['required', 'numeric', 'min:1']),
            'episodesPerSeason' => Rule::when($this->method() === 'POST', ['required', 'numeric', 'min:1']),
        ];
    }
}
