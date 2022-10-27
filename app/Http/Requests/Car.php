<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Car extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'make'=>'string|max:60',
            'model'=>'string|max:60'
        ];
    }
}
