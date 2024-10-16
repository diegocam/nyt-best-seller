<?php

declare(strict_types=1);

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
     */
    public function rules(): array
    {
        return [
            'author' => 'alpha',
            'isbn'   => 'array',
            'isbn.*' => [
                'numeric',
                function ($attribute, $value, $fail): void {
                    if (!preg_match('/^(?:\d{10}|\d{13})$/', $value)) {
                        $fail("The $attribute field must be either 10 or 13 digits.");
                    }
                },
            ],
            'title'  => 'string',
            'offset' => [
                'numeric',
                'min:0',
                function ($attribute, $value, $fail): void {
                    if (((int) $value) % 20 !== 0) {
                        $fail("The $attribute field must be a multiple of 20.");
                    }
                },
            ],
        ];
    }
}
