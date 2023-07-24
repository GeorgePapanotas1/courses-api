<?php

namespace Modules\Course\Adapters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Course\Core\Enums\CourseStatusEnum;

class CourseUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string|in:'.CourseStatusEnum::toString(),
            'is_premium' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Invalid course status. Available statuses: '.CourseStatusEnum::toString(),
        ];
    }
}
