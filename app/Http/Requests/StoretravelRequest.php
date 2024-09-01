<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTravelRequest extends FormRequest
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
            'name' => 'required|min:5|max:150',
            'destination' => 'required|min:2|max:150',
            'start_date' => 'required|min:5|max:150',
            'end_date' => 'required|min:5|max:150',
            'description' => 'nullable|max:250',
            'photo' => 'nullable|image|max:1024'
        ];
    }
}
