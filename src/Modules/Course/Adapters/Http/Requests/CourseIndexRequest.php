<?php

namespace Modules\Course\Adapters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|numeric|max:50',
        ];
    }
}
