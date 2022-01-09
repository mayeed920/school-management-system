<?php

namespace App\Http\Requests;

use App\Models\Clasess;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreClasessRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('clasess_create');
    }

    public function rules()
    {
        return [
            'class_name' => [
                'string',
                'required',
            ],
        ];
    }
}
