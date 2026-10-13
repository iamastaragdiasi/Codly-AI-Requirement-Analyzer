<?php

namespace App\Http\Requests;

use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;

class StoreSourceRequest extends FormRequest
{
    public function authorize(): Response
    {
        return Gate::inspect('contribute', $this->route('project'));
    }

    public function rules(): array
    {
        $isDocument = $this->input('kind') === 'document';
        $documentMimeTypes = 'application/pdf,application/zip,application/x-zip-compressed,application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        $documentFile = $this->file('file');

        if ($documentFile instanceof UploadedFile && strtolower($documentFile->getClientOriginalExtension()) === 'docx') {
            $documentMimeTypes .= ',application/octet-stream';
        }

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
                ? 'required|file|extensions:pdf,docx|mimetypes:'.$documentMimeTypes.'|max:10240'
                : 'prohibited',
        ];
    }
}
