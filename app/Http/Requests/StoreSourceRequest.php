<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('contribute', $this->route('project'));
    }

    public function rules(): array
    {
        $isDocument = $this->input('kind') === 'document';

        return [
            'kind' => 'required|in:text,structured,clarification,document',

            'original' => $isDocument
                ? 'prohibited'
                : 'required|string|max:50000|regex:/\S/u',

            'role' => 'nullable|string|max:200',
            'feature' => 'nullable|string|max:500',

            'priority' => 'required|in:Must,Should,Could,Future',

            'reference' => 'required_if:kind,clarification|nullable|string|max:200',

            'file' => $isDocument
                ? 'required|file|extensions:pdf,docx|max:10240'
                : 'prohibited',
        ];
    }
}
