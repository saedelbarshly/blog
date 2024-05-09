<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
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
            'title' => ['required', 'string', 'unique:blogs,title,' . $this->blog->id],
            'images.*' => ['nullable', 'image', 'max:2048', 'mimes:png,jpg,jpeg'],
            'deleted_images.*' => ['exists:imagables,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.*' => 'Title is required and must be unique.',
            'images.*.*' => 'Images must be valid files (png, jpg, jpeg) and not exceed 2048 KB.',
            'deleted_images.*.exists' => 'Invalid deleted image selected.',
        ];
    }
}
