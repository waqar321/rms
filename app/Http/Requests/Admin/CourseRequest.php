<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 'title' => 'required|min:3|max:50|unique:ecom_course',
            'title' => 'required|min:3|max:50',
            'instructor_id' => 'required|exists:ecom_instructor,id',
            'category_id' => 'required|exists:ecom_category,id',
            'sub_category_id' => 'required|exists:ecom_category,id',
            'duration' => 'nullable|integer|min:1',
            'enrollment_limit' => 'nullable|integer|min:1',
            'level' => 'nullable|string|max:255',
            'price' => 'nullable|numeric|min:0',
            'prerequisites' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'course_material' => 'nullable|string',
            'description' => 'required|string',
            // 'start_date' => 'nullable|date',
            // 'end_date' => 'nullable|date|after_or_equal:start_date',
            'course_format' => 'nullable|string|max:255',
            // 'course_code' => 'nullable|string|unique:ecom_course,course_code',
            'course_code' => 'nullable|string',
            'tags' => 'nullable|string|max:255',
            'course_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
