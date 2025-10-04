<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutRequest extends FormRequest
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
        $rules = [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'image' => 'nullable|image',
            'cv' => 'nullable|file',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'user_id' => 'required|exists:users,id',
            
        ];

        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            $rules['title'] = 'sometimes|required|string|max:255';
            $rules['subtitle'] = 'sometimes|required|string|max:255';
            $rules['description'] = 'sometimes|required|string';
            $rules['image'] = 'sometimes|image';
            $rules['cv'] = 'sometimes|file';
            $rules['linkedin'] = 'sometimes|url';
            $rules['github'] = 'sometimes|url';
            $rules['instagram'] = 'sometimes|url';
            $rules['facebook'] = 'sometimes|url';
            $rules['user_id'] = 'sometimes|required|exists:users,id';
        }

        return $rules;
    }
}
