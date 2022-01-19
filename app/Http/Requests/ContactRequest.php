<?php

namespace App\Http\Requests;

use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape([
        'title' => "string[]",
        'message' => "string[]",
        'attachment' => "string[]"
    ])]
    public function rules(): array
    {
        return [
            'title' => ['required', 'min:5', 'max:255'],
            'message' => ['required', 'min:10'],
            'attachment' => ['required', 'file'],
        ];
    }
}
