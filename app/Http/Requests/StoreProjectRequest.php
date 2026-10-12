<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /** @return array<string,string> */
    public function rules(): array
    {
        return ['revision' => $this->route('project') ? 'required|integer' : 'prohibited', 'name' => 'required|string|max:200', 'business_problem' => 'required|string|max:10000', 'objectives' => 'required|string|max:10000', 'target_users' => 'required|string|max:5000'];
    }
}
