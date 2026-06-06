<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isStudent();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string', 'min:100', 'max:2000'],
            'year' => ['required', 'digits:4', 'integer',
                'min:2000', 'max:'.date('Y')],
            'keywords' => ['nullable', 'string', 'max:255'],
            'supervisor_id' => ['required', 'exists:users,id'],
            'project_file' => ['required', 'file', 'mimes:pdf', 'max:10240'], // 10MB max
        ];
    }

    public function messages(): array
    {
        return [
            'abstract.min' => 'Abstract must be at least 100 characters.',
            'project_file.mimes' => 'Only PDF files are allowed.',
            'project_file.max' => 'File size must not exceed 10MB.',
            'supervisor_id.required' => 'Please select a supervisor.',
        ];
    }
}
