<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BestSellerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author' => 'string',
            'isbn'   => 'array',
            'isbn.*' => 'digits_between:10,13',
            'title'  => 'string',
            'offset' => [
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($value % 20 !== 0) {
                        $fail('The ' . $attribute . ' must be a multiple of 20');
                    }
                },
            ]
        ];
    }
}
