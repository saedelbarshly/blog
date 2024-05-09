<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'title' => ['required','string','unique:blogs,title'],  
            'images.*' => ['required','image','max:2048','mimes:png,jpg,jpeg']
        ];
    }

    public function messages(): array
    {
        return [
            'title.*' => 'Title is required and must be unique.',
            'images.*.*' => 'Images is required must be valid files (png, jpg, jpeg) and not exceed 2048 KB.',
        ];
    }
}
