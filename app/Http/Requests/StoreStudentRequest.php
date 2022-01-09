<?php

namespace App\Http\Requests;

use App\Models\Student;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'country_code_id' => [
                'required',
                'integer',
            ],
            'date_of_birth' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
